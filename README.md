# PHP Terminal Snow Toy

This simple PHP app generates snow in a terminal.


### How to run:
* Quick run: 
  ```shell
  docker pull mmmostrowski/php-snow && docker run -it --rm mmmostrowski/php-snow
  ```
* On Linux and MacOs - simply clone the repository and run: 
  ```shell
  ./run.sh
  ``` 
* On Windows - simply clone the repository and run:
  ```shell
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
```shell
docker run -it --rm mmmostrowski/php-snow snowy
```


### Custom scene 

You can use your custom scene by providing it in a plain text format:

* Generate your custom text file
  * You might [want to find for](https://google.gprivate.com/search.php?search?q=ASCII+text+Generator+site) some ASCII Text Generator site
* Run: 
```shell
docker run -it --rm --volume /path/to/your/scene.txt:/app/scene.txt mmmostrowski/php-snow 
```
* or, clone the project and then simply run:
```shell
./run.sh /path/to/your/scene.txt [preset]
```


