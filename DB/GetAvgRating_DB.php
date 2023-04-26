<?php
function GetAvgRating($OpskriftID) //Udregner den gennemsnitlige rating for en opskrift
{
	$link = OpenDB();
	$queryRating = mysqli_query($link, "Select * FROM OpskriftToRating WHERE OpskriftID=".$OpskriftID." ORDER BY OpskriftID DESC");
	$ratingTotal=0;
	while($rowRating = mysqli_fetch_assoc($queryRating)) //En while der kører alle rækker igennem, og sammentæller Ratinger
		{
			$queryRatingName = mysqli_query($link, "Select * FROM Rating WHERE RatingID=".$rowRating['RatingID']." ORDER BY CreateDate DESC");
			while($rowRatingName = mysqli_fetch_assoc($queryRatingName)) //En while der kører alle rækker igennem,
				{
					$ratingTotal= $ratingTotal + $rowRatingName['Stars'];
				}
		}
	$numRatings = mysqli_num_rows($queryRating);
	if ($ratingTotal > 0)
		{
			$avgRating = $ratingTotal/$numRatings;
		}
	else
		{
			$avgRating = 0;
		}
	return $avgRating;
	CloseDB($link);
}
?>