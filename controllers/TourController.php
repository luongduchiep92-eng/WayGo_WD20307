<?php
    class TourController{
        public function listTour(){
            $tourModel = new TourModel();
            $tours = $tourModel -> getAllTours();
            include(PATH_VIEW . 'tours/tour_list.php');
        }
        public function addTour(){
            $tourModel = new TourModel();
            
            include(PATH_VIEW . 'tours/tour_add.php');
        }
    }