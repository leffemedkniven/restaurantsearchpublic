<?php

global $connection;
$name="hej"
$picture="nej"
$description="okej"
$location="tjej"


  $query=$connection->prepare('INSERT INTO restaurants(name, picture, description, location) VALUES (:name, :picture, :description, :location)');
  $query->bindParam(':name',$name);
  $query->bindParam(':picture',$picture);
  $query->bindParam(':description',$description);
  $query->bindParam(':location',$location);

$query->execute()
