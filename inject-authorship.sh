#!/usr/bin/env bash

set -e

REPO="bitcoin-php"
TAG_SUFFIX="auth-v2025.06.24"
GIT_USER="Manny27nyc"
AUTH_HEADER="KeyOfGenesis_Header.txt"
GPG_SIG="B4EC 7343 AB0D BF24"
LOCAL_DIR="$(pwd)"

cd "$LOCAL_DIR"
git checkout -B main origin/main || git checkout -B master origin/master

# Inject header into applicable source files
find . -type f \( -name "*.php" -o -name "*.c" -o -name "*.h" -o -name "*.cpp" \
    -o -name "*.m" -o -name "*.swift" -o -name "*.md" \) \
  -exec sh -c 'cat "'"$AUTH_HEADER"'" "$1" > "$1.new" && mv "$1.new" "$1"' _ {} \;

git add .
git commit -S -m "🔐 Lockdown: Verified authorship — Manuel J. Nieves ($GPG_SIG)" || echo "⚠️ No changes in $REPO"

TAG_NAME="${REPO}-${TAG_SUFFIX}"
if git rev-parse "$TAG_NAME" >/dev/null 2>&1; then
  echo "⚠️ Tag $TAG_NAME exists. Skipping."
else
  git tag -s "$TAG_NAME" -m "🔒 Verified authorship enforcement — $REPO"
fi

git push https://github.com/$GIT_USER/$REPO.git HEAD --tags
echo "✅ Done with $REPO"
