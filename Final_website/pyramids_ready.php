<?php
	/*This is a 
	multi-line comment*/

	//This is a single-line comment

	#This is also a singe-line comment

	$user = 'root';
	$password = 'dagsforlunch222';
	$db = 'image_information_manager';
	$host = 'localhost';
	$port = 3306;
	$socket = '/var/run/mysqld/mysqld.sock';

	$link = mysqli_init();
	$success = mysqli_real_connect(
	$link,
	$host,
   	$user,
   	$password,
   	$db,
   	$port,
   	$socket
	);


	$sql = "SELECT * FROM `pictures_glioblastoma`";
	$result = mysqli_query($link, $sql);

	
	for ($set = array (); $row = $result->fetch_assoc(); $set[] = $row);

	$number_of_pictures = count($set);

	function getRandomWeightedElement(array $weightedValues) {
		$rand = mt_rand(1, (int) array_sum($weightedValues));

    		foreach ($weightedValues as $key => $value) {
      			$rand -= $value;
      			if ($rand <= 0) {
        			return $key;
      			}
    		}
  	}
	
	
	$sql2 = "SELECT weight FROM `pictures_glioblastoma`";
        $result2 = mysqli_query($link, $sql2);
        for ($set2 = array (); $row = $result2->fetch_assoc(); $set2[] = $row);

        $weight_a = $set2[0]["weight"];
        $weights = array();
        for ($i = 0; $i <= 98; $i++) {
                $weights[$i] = $set2[$i]["weight"];
        }

	

	$a = getRandomWeightedElement($weights) + 1;
	$b = getRandomWeightedElement($weights) + 1;
	$c = getRandomWeightedElement($weights) + 1;
	while ($c == $a | $c == $b | $a == $b){
		$b = getRandomWeightedElement($weights) + 1;
		$c = getRandomWeightedElement($weights) + 1;
	}

	$line_a = $set[($a-1)]["filename"];
	$line_b = $set[($b-1)]["filename"];
	$line_c = $set[($c-1)]["filename"];
	$tag_a = $set[($a-1)]["tag"];
	$tag_b = $set[($b-1)]["tag"];
	$tag_c = $set[($c-1)]["tag"];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Cancer research!</title>
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
  </head>
  <body>
	<div id=page-form3>

		<section class="header">
  			<div class="title-form">
  				<h1>
					Welcome to the Nelander lab
				</h1>
				<h3>
					A classification of Gliobalstoma
				</h3>
  			</div>

  			<div class="logos">
  				<img src="images/SLL_logo-1024x331.png" 
  				style= '
  				margin-right: 10px;
				margin-top: 55px;
				margin-left: 100px; 
				width: 120px'
				alt="SciLifeLab logo">

  				<img src="images/uppsala.jpg" width="160" alt="Uppsala university logo">
  				

  				
  			</div>
		</section>

		<div id=text-form>
			<div id=message2>
				You are comparing the cases A, B, and C. Which case is the most unlike the others in terms of cancer growth characteristics?
                        </div>
			<?php
				
				if(!empty($_POST["radio"])){
					echo "<div id=message>";
					$str = $_POST["radio"];
					$variable = explode(" ",$str);

					$A = $variable[0];
					$B = $variable[1];
					$C = $variable[2];
		
					#echo "The most unlike picture out of $A, $B and $C was $C."; 

					$sql = "INSERT INTO `Data_points_final_project_mouses` (`id`, `similar1`, `similar2`, `dissimilar`) VALUES (NULL, '$A', '$B', '$C')";

					#echo $sql;

					if (mysqli_query($link, $sql)) {
				 		echo " New record created successfully.";
					} 
					else {
				 		echo "Error: " . $sql . "<br>" . mysqli_error($link);
					}
					echo "</div>";
				}

			?>
 
			<div style="margin: 0px;">
				<div style="float: left; width: 465px; margin-right: 2px;">
					<!--
					A:
					--> 
					<?php
                                        #echo $link_a;
                                        echo "<br>";
                                        echo "<form action='' method='post'>
                                                <button name='radio' value='$c $b $a'>A</button>
                                                </form>";
					?>
					<div id="openseadragon1" style="width: 100%; height: 600px;"></div>
					<script src="/openseadragon/openseadragon.min.js"></script>
					<script src="bildnamn_med_koordinater.js"></script>
					<script src="filenames_tags.js"></script>
					<script src="cell_lines.js"></script>
					<script type="text/javascript">

						<?php
							echo "var image = '$line_a';" //tag was previously 'cell_line'
						?>
						
						//var available_tags = dict_cell_line_to_taglist[cell_line]
						//var tag = available_tags[Math.floor(Math.random() * available_tags.length)];
						//console.log(tag)
						//console.log( Math.random() * dict_cell_line_to_taglist.length )
						//console.log(dict_cell_line_to_taglist)
						//console.log(cell_line)
						//console.log(tags_to_filenames)
						//var image = tags_to_filenames[tag];

					    var viewer1 = OpenSeadragon({
					    	defaultZoomLevel: 3,
					    	minZoomLevel: 	0.8,
    						maxZoomLevel: 	200,
					        id: "openseadragon1",
					        prefixUrl: "/openseadragon/images/",
					        tileSources: "/Pyramids/"+image
					    });
						var tag = filenames_tags[image];
						console.log(tag)
						console.log(image)
				    	var desired_pixel_1x1;
					    var desired_pixel_1y1;
					    var desired_pixel_1x2;
					    var desired_pixel_1y2;
					    [desired_pixel_1x1, desired_pixel_1y1, desired_pixel_1x2, desired_pixel_1y2] = tags_with_coords[tag];
					    console.log(tags_with_coords[tag])
					    //var desired_pixel_2x1 = 13000
					    //var desired_pixel_2y1 = 27000
					    //var desired_pixel_2x2 = 25000
					    //var desired_pixel_2y2 = 42500

						viewer1.addHandler('open', function() {

					    	var imagex_size = viewer1.world.getItemAt(0).getContentSize().x;
					    	var imagey_size = viewer1.world.getItemAt(0).getContentSize().y;

					    	var relative_positionx =  desired_pixel_1x1 / imagex_size
					    	var relative_positiony =  desired_pixel_1y1 / imagey_size

					    	var relative_width = (desired_pixel_1x2 - desired_pixel_1x1) / imagex_size
					    	var relative_height = (desired_pixel_1y2 - desired_pixel_1y1) / imagey_size

					    	var bounds1 = new OpenSeadragon.Rect(relative_positionx, relative_positiony, relative_width, relative_height, 0);
  							viewer1.viewport.fitBounds(bounds1, true);
						});

						viewer1.viewport.goHome = function(immediately) {
						 	var imagex_size = viewer1.world.getItemAt(0).getContentSize().x;
					    	var imagey_size = viewer1.world.getItemAt(0).getContentSize().y;

					    	var relative_positionx =  desired_pixel_1x1 / imagex_size
					    	var relative_positiony =  desired_pixel_1y1 / imagey_size

					    	var relative_width = (desired_pixel_1x2 - desired_pixel_1x1) / imagex_size
					    	var relative_height = (desired_pixel_1y2 - desired_pixel_1y1) / imagey_size

					    	var bounds1 = new OpenSeadragon.Rect(relative_positionx, relative_positiony, relative_width, relative_height, 0);
						    if( this.viewer1 ){
						        this.viewer1.raiseEvent( 'home', {
						            immediately: immediately
						        });
						    }
						    this.fitBounds(bounds1, immediately); 
						};
					</script> 


				</div>

				<div style="float: left; width: 465px; margin-right: 1px; margin-left: 1px;">
					<!--
					B:
					--> 
					
					
					
					<?php
					
					
                                        echo "<br>";
                                        echo "<form action='' method='post'>
                                                <button name='radio' value='$c $a $b'>B</button>
                                                </form>";
					?>
					<div id="openseadragon2" style="width: 100%; height: 600px;"></div>
					<script src="/openseadragon/openseadragon.min.js"></script>
					<script src="bildnamn_med_koordinater.js"></script>
					<script src="filenames_tags.js"></script>
					<script src="cell_lines.js"></script>
					<script type="text/javascript">

						<?php
							echo "var image = '$line_b';" //tag was previously 'cell_line'
						?>

						//var available_tags = dict_cell_line_to_taglist[cell_line]
                                                //var tag = available_tags[Math.floor(Math.random() * available_tags.length)];
						//var image = tags_to_filenames[tag];

					    var viewer2 = OpenSeadragon({
					    	defaultZoomLevel: 3,
					    	minZoomLevel: 	0.8,
    						maxZoomLevel: 	200,
					        id: "openseadragon2",
					        prefixUrl: "/openseadragon/images/",
					        tileSources: "/Pyramids/"+image
					    });
					    
					    var tag = filenames_tags[image]
					    var desired_pixel_2x1;
					    var desired_pixel_2y1;
					    var desired_pixel_2x2;
					    var desired_pixel_2y2;
					    [desired_pixel_2x1, desired_pixel_2y1, desired_pixel_2x2, desired_pixel_2y2] = tags_with_coords[tag];
						console.log(tags_with_coords[tag])
					    viewer2.addHandler('open', function() {

					    	var imagex_size = viewer2.world.getItemAt(0).getContentSize().x;
					    	var imagey_size = viewer2.world.getItemAt(0).getContentSize().y;

					    	var relative_positionx =  desired_pixel_2x1 / imagex_size
					    	var relative_positiony =  desired_pixel_2y1 / imagey_size

					    	var relative_width = (desired_pixel_2x2 - desired_pixel_2x1) / imagex_size
					    	var relative_height = (desired_pixel_2y2 - desired_pixel_2y1) / imagey_size

					    	var bounds2 = new OpenSeadragon.Rect(relative_positionx, relative_positiony, relative_width, relative_height, 0);
  							viewer2.viewport.fitBounds(bounds2, true);
						});


						viewer2.viewport.goHome = function(immediately) {
						 	var imagex_size = viewer2.world.getItemAt(0).getContentSize().x;
					    	var imagey_size = viewer2.world.getItemAt(0).getContentSize().y;

					    	var relative_positionx =  desired_pixel_2x1 / imagex_size
					    	var relative_positiony =  desired_pixel_2y1 / imagey_size

					    	var relative_width = (desired_pixel_2x2 - desired_pixel_2x1) / imagex_size
					    	var relative_height = (desired_pixel_2y2 - desired_pixel_2y1) / imagey_size

					    	var bounds2 = new OpenSeadragon.Rect(relative_positionx, relative_positiony, relative_width, relative_height, 0);
						    if( this.viewer2 ){
						        this.viewer2.raiseEvent( 'home', {
						            immediately: immediately
						        });
						    }
						    this.fitBounds(bounds2, immediately); 
						};

					</script>



				</div>
				<div style="float: left; width: 465px; margin-left: 2px;">
					<!--
					C:
					-->  

				
					<?php
                                        #echo $link_a;
                                        echo "<br>";
                                        echo "<form action='' method='post'>
                                                <button name='radio' value='$a $b $c'>C</button>
                                                </form>";
                                        ?>
					<div id="openseadragon3" style="width: 100%; height: 600px;"></div>
					<script src="/openseadragon/openseadragon.min.js"></script>
					<script src="bildnamn_med_koordinater.js"></script>
					<script src="filenames_tags.js"></script>
					<script src="cell_lines.js"></script>
					<script type="text/javascript">

						<?php
							echo "var image = '$line_c';" //tag was previously 'cell_line'
						?>
								
						//var available_tags = dict_cell_line_to_taglist[cell_line]
                                                //var tag = available_tags[Math.floor(Math.random() * available_tags.length)];
						//var image = tags_to_filenames[tag];
						//console.log(cell_line)
						//console.log(tag)
					    var viewer3 = OpenSeadragon({
					    	defaultZoomLevel: 3,
					    	minZoomLevel: 	0.8,
    						maxZoomLevel: 	200,
					        id: "openseadragon3",
					        prefixUrl: "/openseadragon/images/",
					        tileSources: "/Pyramids/"+image
					    });
					    var tag = filenames_tags[image]
					    var desired_pixel_3x1;
					    var desired_pixel_3y1;
					    var desired_pixel_3x2;
					    var desired_pixel_3y2;
					    [desired_pixel_3x1, desired_pixel_3y1, desired_pixel_3x2, desired_pixel_3y2] = tags_with_coords[tag];
						console.log(tags_with_coords[tag])					    
						viewer3.addHandler('open', function() {
						
					    	var imagex_size = viewer3.world.getItemAt(0).getContentSize().x;
					    	var imagey_size = viewer3.world.getItemAt(0).getContentSize().y;

					    	var relative_positionx =  desired_pixel_3x1 / imagex_size
					    	var relative_positiony =  desired_pixel_3y1 / imagey_size

					    	var relative_width = (desired_pixel_3x2 - desired_pixel_3x1) / imagex_size
					    	var relative_height = (desired_pixel_3y2 - desired_pixel_3y1) / imagey_size

					    	var bounds3 = new OpenSeadragon.Rect(relative_positionx, relative_positiony, relative_width, relative_height, 0);
  							viewer3.viewport.fitBounds(bounds3, true);
						});

						viewer3.viewport.goHome = function(immediately) {
						 	var imagex_size = viewer3.world.getItemAt(0).getContentSize().x;
					    	var imagey_size = viewer3.world.getItemAt(0).getContentSize().y;

					    	var relative_positionx =  desired_pixel_3x1 / imagex_size
					    	var relative_positiony =  desired_pixel_3y1 / imagey_size

					    	var relative_width = (desired_pixel_3x2 - desired_pixel_3x1) / imagex_size
					    	var relative_height = (desired_pixel_3y2 - desired_pixel_3y1) / imagey_size

					    	var bounds3 = new OpenSeadragon.Rect(relative_positionx, relative_positiony, relative_width, relative_height, 0);
						    if( this.viewer3 ){
						        this.viewer3.raiseEvent( 'home', {
						            immediately: immediately
						        });
						    }
						    this.fitBounds(bounds3, immediately); 
						};
					</script>


				</div>
				 <br style="clear: left;" />
			</div>

		</div>
		<br>
		<a href="index.html">Back to home page.</a>
	</div>







  </body>
</html>
