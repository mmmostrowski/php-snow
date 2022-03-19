@echo off

docker build -t php-snow .

cls

docker run -it --rm --name php-snow php-snow %*

