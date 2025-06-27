#!/bin/bash

echo "===== Audit Summary — Phase II ====="
echo ""
for f in _*.txt; do
  echo "▶️  $f — $(wc -l < "$f") lines"
  echo "------------------------"
  head -n 10 "$f"
  echo ""
done
