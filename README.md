# PHP Terminal Snow Toy

This simple PHP app generates snow in a terminal.

### Quick run

```shell
docker pull mmmostrowski/php-snow && docker run -it --rm mmmostrowski/php-snow
```

#### Run custom scene
```shell
docker pull mmmostrowski/php-snow && docker run -it --rm mmmostrowski/php-snow https://raw.githubusercontent.com/mmmostrowski/php-snow/main/scene-example.txt massiveSnow
```


### Run locally 
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

To run a preset simply add the preset code to the end of the command. E.x.:
```shell
docker run -it --rm mmmostrowski/php-snow snowy
```


### Custom scene 

You can provide custom scenes in plain text format:

* Generate your custom text file
  * You might [want to use](https://google.gprivate.com/search.php?search?q=ASCII+text+Generator+site) some ASCII Text Generator site for that purpose
* Run: 
```shell
docker run -it --rm --volume /path/to/your/scene.txt:/app/scene.txt mmmostrowski/php-snow 
```
* or, clone the project and then simply run:
```shell
./run.sh /path/to/your/scene.txt [preset]
```


### Send Postcard to your friend!

If your friend has a Docker installed you may want to send a postcard.
Simple make your scene available publicly and send a docker command to your friend:
```shell
docker run -it --rm mmmostrowski/php-snow https://domain.com/url/to/scene.txt [preset]
```




