if [ -d "/var/www/micropost_current" ]; then
  sudo rm -fR /var/www/micropost_old && \
  sudo cp -R /var/www/micropost_current /var/www/micropost_old/
fi
sudo rm /var/www/micropost && \
sudo rm -R /var/www/micropost_current && \
sudo ln -s /var/www/micropost_old /var/www/micropost