<style>
    .nav-tabs>li.active>a {
        background-color: #5C9BCC !important;
        font-weight: bold;
        color: white;
        border-radius: 15px 50px;

    }

    .nav-tabs>li>a {
        background-color: #E2E2E2 !important;
        font-weight: bold;
        color: gray;
        border-radius: 15px 50px;
    }
</style>

<ul class="nav nav-tabs" style="margin-bottom: 5px;">

    <li class="<?php echo $menu == 'pending_cases' ? 'active' : '' ?>">
        <a href="<?php echo site_url('/visits/visit_list/?menu=pending_cases'); ?>"><i class="fa fa-clock-o" aria-hidden="true"></i> Pending Cases</a>
    </li>

    <li class="<?php echo $menu == 'not_visited_list' ? 'active' : '' ?>">
        <a href="<?php echo site_url('/visits/visit_list/?menu=not_visited_list'); ?>"><i class="fa fa-clock-o" aria-hidden="true"></i> Not Visited List</a>
    </li>
    <li class="<?php echo $menu == 'not_visited_summary' ? 'active' : '' ?>">
        <a href="<?php echo site_url('/visits/visit_list/?menu=not_visited_summary'); ?>"><i class="fa fa-clock-o" aria-hidden="true"></i> Not Visited Summary</a>
    </li>



    <li class="<?php echo $menu == 'visited_list' ? 'active' : '' ?>">
        <a href="<?php echo site_url('/visits/visit_list/?menu=visited_list'); ?>"><i class="fa fa-check" aria-hidden="true"></i> Visited List</a>

    </li>
</ul>