!bin/bash

if [ ! -d  /var/www/code/node_modules ]; then
  npm install
fi

if [ ! -f /var/www/code/assets/bundle.js ]; then
  npm run build
fi