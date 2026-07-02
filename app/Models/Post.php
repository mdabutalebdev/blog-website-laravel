<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Post {
    public static function all() {
        $db = Database::getInstance();
        $stmt = $db->query("
            SELECT posts.*, users.name as author_name, users.avatar as author_avatar,
                   (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as like_count,
                   (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count
            FROM posts 
            JOIN users ON posts.author_id = users.id 
            WHERE posts.is_approved = 1
            ORDER BY posts.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public static function create($author_id, $title, $slug, $content, $cover_image = null, $category = null) {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO posts (author_id, title, slug, content, cover_image, category, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$author_id, $title, $slug, $content, $cover_image, $category]);
        return $db->lastInsertId();
    }

    public static function findBySlug($slug) {
        $db = Database::getInstance();
        $user_id = $_SESSION['user_id'] ?? 0;
        $stmt = $db->prepare("
            SELECT posts.*, users.name as author_name, users.avatar as author_avatar,
                   (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as like_count,
                   (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count,
                   (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id AND user_id = ?) as user_has_liked
            FROM posts 
            JOIN users ON posts.author_id = users.id 
            WHERE posts.slug = ? LIMIT 1
        ");
        $stmt->execute([$user_id, $slug]);
        return $stmt->fetch();
    }

    public static function getCategoriesWithCounts() {
        $db = Database::getInstance();
        $stmt = $db->query("
            SELECT category, COUNT(*) as count 
            FROM posts 
            WHERE category IS NOT NULL AND category != '' AND is_approved = 1
            GROUP BY category 
            ORDER BY count DESC
        ");
        return $stmt->fetchAll();
    }

    public static function findByCategory($category) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT posts.*, users.name as author_name, users.avatar as author_avatar,
                   (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as like_count,
                   (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count
            FROM posts 
            JOIN users ON posts.author_id = users.id 
            WHERE posts.category = ? AND posts.is_approved = 1
            ORDER BY posts.created_at DESC
        ");
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    }

    public static function searchAndFilterPaginated($query = null, $category = null, $page = 1, $perPage = 12) {
        $db = Database::getInstance();
        
        $baseSql = "
            FROM posts 
            JOIN users ON posts.author_id = users.id 
            WHERE posts.is_approved = 1
        ";
        
        $params = [];

        if (!empty($category)) {
            $baseSql .= " AND posts.category = ?";
            $params[] = $category;
        }

        if (!empty($query)) {
            $baseSql .= " AND (posts.title LIKE ? OR posts.content LIKE ? OR users.name LIKE ?)";
            $searchTerm = '%' . $query . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        // Get total count
        $countSql = "SELECT COUNT(*) as total " . $baseSql;
        $countStmt = $db->prepare($countSql);
        $countStmt->execute($params);
        $total = $countStmt->fetch()['total'];

        // Get paginated data
        $dataSql = "
            SELECT posts.*, users.name as author_name, users.avatar as author_avatar,
                   (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as like_count,
                   (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count
        " . $baseSql . " ORDER BY posts.created_at DESC LIMIT ? OFFSET ?";
        
        $offset = ($page - 1) * $perPage;
        
        $params[] = $perPage;
        $params[] = $offset;

        $dataStmt = $db->prepare($dataSql);
        // PDO bindParam is needed for LIMIT/OFFSET if PDO::ATTR_EMULATE_PREPARES is true, but since we are executing with array, they are passed as strings.
        // It's safer to bind them properly or make sure they are integers, but in PDO with emulation on, it might fail.
        // Let's bind them explicitly.
        
        foreach ($params as $key => $val) {
            $type = is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $dataStmt->bindValue($key + 1, $val, $type);
        }
        
        $dataStmt->execute();
        $data = $dataStmt->fetchAll();

        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page
        ];
    }

    public static function searchAndFilter($query = null, $category = null) {
        $db = Database::getInstance();
        $sql = "
            SELECT posts.*, users.name as author_name, users.avatar as author_avatar,
                   (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as like_count,
                   (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count
            FROM posts 
            JOIN users ON posts.author_id = users.id 
            WHERE posts.is_approved = 1
        ";
        $params = [];

        if (!empty($category)) {
            $sql .= " AND posts.category = ?";
            $params[] = $category;
        }

        if (!empty($query)) {
            $sql .= " AND (posts.title LIKE ? OR posts.content LIKE ? OR users.name LIKE ?)";
            $searchTerm = '%' . $query . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        $sql .= " ORDER BY posts.created_at DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function getRelatedPosts($category, $excludeId, $limit = 4) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT id, title, slug
            FROM posts 
            WHERE category = ? AND id != ? AND is_approved = 1
            ORDER BY created_at DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $category);
        $stmt->bindValue(2, $excludeId);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getByUser($user_id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT posts.*, users.name as author_name, users.avatar as author_avatar,
                   (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as like_count,
                   (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comment_count
            FROM posts 
            JOIN users ON posts.author_id = users.id 
            WHERE posts.author_id = ?
            ORDER BY posts.created_at DESC
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    public static function findById($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM posts WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function update($id, $title, $content, $cover_image, $category) {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE posts SET title = ?, content = ?, cover_image = ?, category = ? WHERE id = ?");
        return $stmt->execute([$title, $content, $cover_image, $category, $id]);
    }

    public static function delete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function getPendingPosts() {
        $db = Database::getInstance();
        $stmt = $db->query("
            SELECT posts.*, users.name as author_name, users.avatar as author_avatar
            FROM posts 
            JOIN users ON posts.author_id = users.id 
            WHERE posts.is_approved = 0
            ORDER BY posts.created_at ASC
        ");
        return $stmt->fetchAll();
    }

    public static function approve($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE posts SET is_approved = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
