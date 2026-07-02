import os
import re

def fix_double_escape(text):
    # This regex looks for {{ e( ... ) }}
    # We will use a stack to find the matching closing parenthesis
    
    result = ""
    i = 0
    while i < len(text):
        if text.startswith("{{ e(", i):
            result += "{{ "
            i += 5
            
            # Find the matching closing parenthesis for e(
            depth = 1
            content = ""
            while i < len(text) and depth > 0:
                if text[i] == '(':
                    depth += 1
                elif text[i] == ')':
                    depth -= 1
                    
                if depth > 0:
                    content += text[i]
                i += 1
                
            result += content
            
            # now we expect " }}" but there might be spaces
            # The original had {{ e(...) }}
            # Our output is {{ content }}
        else:
            result += text[i]
            i += 1
            
    return result

view_dir = "F:\\blog site root\\blog-site-laravel\\resources\\views"
for root, dirs, files in os.walk(view_dir):
    for file in files:
        if file.endswith(".blade.php"):
            path = os.path.join(root, file)
            with open(path, "r", encoding="utf-8") as f:
                content = f.read()
                
            new_content = fix_double_escape(content)
            
            if new_content != content:
                with open(path, "w", encoding="utf-8") as f:
                    f.write(new_content)
                print(f"Fixed {path}")

print("Done")
