<?php 
	session_start();

	if (!isset($_SESSION['username'])) {
		header('Location: index.php');
		exit();
	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale = 1.0">
	<title>Envelope</title>
	<?php include 'includes/stylesheets.php'; ?>
</head>
<body>
	<div id="homepage">
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<a href="index.php" class="navbar-brand"><img src="assets/images/envelope-w.png" alt="" class="img-responsive"></a>
				</div>
			</div>	
		</nav>
		
		<div class="middle-color">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h3 class="text-center"><strong>About</strong></h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius unde provident, fugiat ut eveniet nisi id expedita voluptatem ad magni explicabo maiores obcaecati maxime! Tempora inventore, culpa molestias provident maxime? Voluptate nam velit, voluptas recusandae magni unde totam autem molestiae dolore temporibus rem, nulla ratione aspernatur, fuga tenetur similique necessitatibus accusamus voluptatibus, praesentium. Reprehenderit nobis numquam perferendis facere aliquam in quae praesentium error voluptatum iusto! Labore eveniet maxime, officiis eius aliquam minima excepturi voluptatem unde laudantium, blanditiis a. Magni voluptates hic alias possimus a beatae, explicabo necessitatibus numquam commodi, consequatur, laborum sed perspiciatis sequi pariatur nemo qui accusantium dicta ut sapiente. Assumenda blanditiis dignissimos debitis et ullam perferendis officiis mollitia non ex,</p>
					</div>
				</div>
			</div>
		</div>
		
		<?php include 'includes/scripts.php'; ?>
	
	</div>
</body>
</html>