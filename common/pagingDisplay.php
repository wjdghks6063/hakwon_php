<style>
.page-number a {
    border: 1px solid #999;
    padding: 2px 5px;
    margin: 2px;
}
.page-number a:hover {
    color: white;
    font-weight: bold;
	background:#6dacb8;
}
</style>
<?       
	    $blockno = floor($current / $perblock);
        $blockstart = $perblock * $blockno;
		
        if($blockno > 0){
            $prevblock = $blockstart-1;
?>		
			<a href="javascript:goPage('0')" class="icon"><i class="fas fa-angle-double-left"></i></a>
			<a href="javascript:goPage('<?=$prevblock?>')" class="icon"><i class="fas fa-angle-left"></i></a>
<?			
        }
		
        for($j=$blockstart ; $j<$blockstart + $perblock ; $j++){
            if($j < $pageGroupCount){
                if($j == $current){
                    $k = $j + 1;
					echo "<a class='on'>$k</a>";
                }else{
                    $k = $j + 1;
?>					
					<a href="javascript:goPage('<?=$j?>')"><?=$k?></a>
<?					
                }
            }
        }
        if($blockno < $blocklen-1){
            $nextblock = $blockstart + $perblock;
            $lastblock = $pageGroupCount - 1;
?>			
			<a href="javascript:goPage('<?=$nextblock?>')" class="icon"><i class="fas fa-angle-right"></i></a>
			<a href="javascript:goPage('<?=$lastblock?>')" class="icon"><i class="fas fa-angle-double-right"></i></a>
<?
		}
?>	

	