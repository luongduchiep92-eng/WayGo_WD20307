<?php
    class TourController{
        public function listTour(){
            $tourModel = new TourModel();
<<<<<<< HEAD
            $tours = $tourModel -> getAllTours();
            include(PATH_VIEW . 'tours/tour_list.php');
        }
        public function addTour(){
            $tourModel = new TourModel();
            
            include(PATH_VIEW . 'tours/tour_add.php');
        }
=======
            $tours = $tourModel -> getAllTour();
            include(PATH_VIEW . 'tours/tour_list.php');
        }
>>>>>>> 75241b5a66087a5b3d6291071368de26c9d794e4
    }