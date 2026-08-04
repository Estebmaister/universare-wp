#!/usr/bin/env bash
# Test cPanel FTP credentials before GitHub Actions deploy.
# Usage: FTP_PASSWORD='your-cpanel-password' ./scripts/test-ftp.sh

set -euo pipefail

HOST="${FTP_HOST:-ftp.universare.com}"
USER="${FTP_USER:-univers3}"
PASS="${FTP_PASSWORD:?Set FTP_PASSWORD env var}"

echo "Testing FTP to ${USER}@${HOST} ..."
if curl -sS --ftp-pasv -u "${USER}:${PASS}" "ftp://${HOST}/" | head -5; then
  echo "OK: FTP login succeeded"
else
  echo "FAIL: FTP login failed (530 = bad user/password)"
  exit 1
fi

echo "Testing theme path ..."
if curl -sS --ftp-pasv -u "${USER}:${PASS}" "ftp://${HOST}/public_html/wp-content/themes/" | head -5; then
  echo "OK: can list themes directory"
else
  echo "FAIL: cannot access public_html/wp-content/themes/"
  exit 1
fi
