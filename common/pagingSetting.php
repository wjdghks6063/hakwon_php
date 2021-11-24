<?		
        $all = mysqli_query($connect,$countTotal);
        
        $totalCount = mysqli_num_rows($all);

        // 페이지 당 게시물 수
        $onePageListCount = $countOnePage; //common으로 넘어감
        
        $pageGroupCount = ceil($totalCount / $onePageListCount);
    
        // 페이지 블록 당 페이지넘버 개수
//        $perblock = $countOnePage;  // 몇개 페이지를 한블록으로  
        $blocklen = ceil($pageGroupCount / $perblock);

        if(isset($_POST['t_page'])){
            $current = $_POST['t_page'];
        }else {
            $current = 0;
        }
        $start = $onePageListCount * $current;
        $end = $onePageListCount;		
?>