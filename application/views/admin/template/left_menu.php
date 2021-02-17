<div class="page-sidebar-wrapper">

    <div class="page-sidebar navbar-collapse collapse">

        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item <?php if($current == 'dashboard'){ echo 'start active open';} ?>">
                <a href="/admin" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">관리자홈</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <li class="nav-item <?php if($current == 'smsResults'){ echo 'start active open';} ?>">
                <a href="/admin/smsResults" class="nav-link nav-toggle">
                    <i class="icon-envelope-letter"></i>
                    <span class="title">발송 결과</span>
                    <span class="arrow"></span>
                </a>
            </li>

            <li class="nav-item <?php if($current == 'users'){ echo 'start active open';} ?>">
                <a href="/admin/members" class="nav-link nav-toggle">
                    <i class="icon-user"></i>
                    <span class="title">회원관리</span>
                    <span class="arrow"></span>
                </a>
            </li>

            <li class="nav-item <?php if($current == 'smsAddRequets'){ echo 'start active open';} ?>">
                <a href="/admin/smsAddRequets" class="nav-link nav-toggle">
                    <i class="icon-speech"></i>
                    <span class="title">SMS 승인 요청</span>
                    <span class="arrow"></span>
                </a>

            </li>

            <li class="nav-item <?php if($current == 'admin'){ echo 'start active open';} ?>">
                <a href="/admin/edit" class="nav-link nav-toggle">
                    <i class="icon-note"></i>
                    <span class="title">관리자정보설정</span>
                    <span class="arrow"></span>
                </a>

            </li>
            
            <li class="nav-item <?php if($current == 'rec_code'){ echo 'start active open';} ?>">
                <a href="/admin/recommendation" class="nav-link nav-toggle">
                    <i class="icon-paper-plane"></i>
                    <span class="title">추천 코드</span>
                    <span class="arrow"></span>
                </a>

            </li>
           
            <?php if($this->session->userdata('user_level') == 'Super admin') {?>
            <li class="nav-item <?php if($current == 'smsAccount'){ echo 'start active open';} ?>">
                <a href="/admin/smsAccount_list" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">SMS 계정</span>
                    <span class="arrow"></span>
                </a>

            </li>
            <li class="nav-item <?php if($current == 'meta'){ echo 'start active open';} ?>">
                <a href="/admin/meta" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">meta</span>
                    <span class="arrow"></span>
                </a>
            </li>
            
            <li class="nav-item <?php if($current == 'report'){ echo 'start active open';} ?>">
                <a href="/admin/report" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">통계</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <li class="nav-item <?php if($current == 'notice'){ echo 'start active open';} ?>">
                <a href="/admin/notice" class="nav-link nav-toggle">
                    <i class="icon-list"></i>
                    <span class="title">공지사항</span>
                    <span class="arrow"></span>
                </a>
            </li>
            <?php }?>
            <li class="nav-item <?php if($current == 'payment'){ echo 'start active open';} ?>">
                <a href="/admin/statisticPayment" class="nav-link nav-toggle">
                    <i class="icon-pie-chart"></i>
                    <span class="title">지불 통계</span>
                    <span class="arrow"></span>
                </a>
            </li>

            <li class="nav-item <?php if($current == 'popup'){ echo 'start active open';} ?>">
                <a href="/admin/popup" class="nav-link nav-toggle">
                    <i class="icon-pie-chart"></i>
                    <span class="title">팝업</span>
                    <span class="arrow"></span>
                </a>
            </li>


        </ul>

    </div>

</div>
