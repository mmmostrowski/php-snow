@echo off

cls

FOR /F "tokens=* USEBACKQ" %%F IN (`docker build --file docker/Dockerfile --quiet .`) DO (
SET imageId=%%F
)

docker run -it --rm ^
    --volume "%cd%\app:/app/" ^
    --env PHP_SNOW_APP_MODE=develop ^
    %imageId% ^
    %*

cls
