echo "===== Audit Summary — Phase III ====="
echo ""
for f in _phase3_all_php.txt _phase3_nonamespaces.txt _phase3_noobjects.txt _src_unknown_php.txt; do
  echo "▶️  $f — $(wc -l < "$f") lines"
  echo "------------------------"
  head -n 10 "$f"
  echo ""
done
