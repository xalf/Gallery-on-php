<?php
	class Album{
		public $id;
		public $name;
		public $image;
		public $crop_x;
		public $crop_y;

		public function __construct($id, $name, $image, $crop_x, $crop_y){
			$this->id = $id;
			$this->name = $name;
			$this->image = $image;
			$this->crop_y = $crop_y;
			$this->crop_x = $crop_x;
		}
	}

	class Image{
		public $id;
		public $album;
		public $image;

		public function __construct($id, $image, $album){
			$this->id = $id;
			$this->image = $image;
			$this->album = $album;
		}
	}
?>