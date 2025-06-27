#!/bin/bash
HEADER="// © 2008–2025 Manuel J. Nieves (Satoshi Norkomoto)\n// 🔐 Enforcement: 17 U.S. Code § 102 & § 1201\n// License required for use. Authorship notarized.\n"

while IFS= read -r file; do
  if [[ -f "$file" ]]; then
    # Avoid duplicate injection
    grep -q "Manuel J. Nieves" "$file" && continue

    tmpfile=$(mktemp)
    echo -e "$HEADER" > "$tmpfile"
    cat "$file" >> "$tmpfile"
    mv "$tmpfile" "$file"
    echo "$file" >> _phase_deep_license_injected.txt
  fi
done < _phase_deep_php_scan.txt
