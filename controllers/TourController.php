<?php
    class TourController{
        public function listTour(){
            $tourModel = new TourModel();
            $tours = $tourModel -> getAllTour();
            include(PATH_VIEW . 'tours/tour_list.php');
        }
    }