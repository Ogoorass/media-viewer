#!/bin/bash

for file in /var/www/samba/wspolne/piotr/*.jpg; do
  fileName="${file##/var/www/samba/wspolne/piotr/}"
  fileBaseName="${fileName%%.jpg}"
  mkdir $fileBaseName
  cd $fileBaseName

  ln -s $file $fileName
  
  ffmpeg -i $file -q:v 50 -vf scale=720:-1 thumbnail.jpg

  cd ../
  echo $fileBaseName
done
