<?php

function is_img($path)
{
	return (bool) preg_match('@\.(jpg|jpeg|png)$@', strtolower($path));
}
