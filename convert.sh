#!/bin/bash

readarray -d '' files < <(find *.jpg -print0)
for file in "${files[@]}" ; do
  file_raw="${file%.jpg}"
  mkdir "${file_raw}"
  mv "${file}" "${file_raw}/" 
  ffmpeg -i "${file_raw}/${file}" -vf scale=512:-1  "${file_raw}/thumbnail.jpg"
  echo done "${file}"
done
echo
