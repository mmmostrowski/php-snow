# PHP Terminal Snow Toy

This simple PHP app generates snow in a terminal.


### How to run:
* Quick run: 
  ```
  docker pull mmmostrowski/php-snow && docker run -it --rm mmmostrowski/php-snow
  ```
* On Linux and MacOs - simply clone the repository and run: 
  ```
  ./run.sh
  ``` 
* On Windows - simply clone the repository and run:
  ```
  run.bat
  ``` 
### Presets

There are a couple of presets available:
* `classical`
* `calm`
* `windy`
* `snowy`
* `massiveSnow`
* `noSnow`
* `noWind`
* `noGravity`
* `testPerformance`
* `testWind`

To run a preset simply add the preset name to the command. E.x.:
```
docker run -it --rm mmmostrowski/php-snow snowy
```


