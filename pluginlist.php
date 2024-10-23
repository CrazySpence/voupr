<? require('component.php'); ?>
<? require('database.php'); ?>
<? require('utilities.php'); ?>

<?
	$query = 'SELECT * FROM
			(
				SELECT table1.*, table2.users FROM
				(
					SELECT * FROM
					(
						(
							SELECT plugins.*, AVG(ratings.rating) AS rating
							FROM plugins, ratings
							WHERE plugin=name
							GROUP BY name
						)
						UNION
						(
							SELECT *, 0 AS rating
							FROM plugins
							WHERE true
						)
					) AS table0
					GROUP BY name
				) AS table1,
				(
					SELECT * FROM
					(
						(
							SELECT plugins.name, COUNT(installed.user) AS users
							FROM plugins, installed
							WHERE plugin=name
							GROUP BY name
						)
						UNION
						(
							SELECT plugins.name, 0 AS users
							FROM plugins
							WHERE true
						)
					) AS table0
					GROUP BY name
				) AS table2
				WHERE table2.name=table1.name
			) AS table3
			WHERE true '.$condition;
			if ($sort) { $query = $query.' ORDER BY '.$sort; }
	$result = mysqli_query($db,$query);
?>
