#!/bin/bash
AUTH_HEADER_FILE=~/Bitcoin_Notarized_SignKit/authorsign.lockdown

find . -type f -name "*.php" | while read -r file; do
  if ! grep -q "Verified Authorship Notice" "$file"; then
    tmp="${file}.new"
    cat "$AUTH_HEADER_FILE" "$file" > "$tmp" && mv "$tmp" "$file"
    echo "Injected header into $file"
  else
    echo "Header already present in $file"
  fi
done

git add .
git commit -S -m "🔐 Lockdown: Verified authorship — Manuel J. Nieves (B4EC 7343)"
git push origin main
