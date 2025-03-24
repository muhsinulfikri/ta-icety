<!-- Side Nav START -->
<div class="side-nav">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="<?= url('dashboard') ?>"
                    style="<?= $title == 'Dashboard' ? 'color: #4b94f7 ; background-color: #e2edfe' : '' ?>;">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"
                            style="<?= $title == 'Dashboard' ? 'color: #4b94f7;' : '' ?>;"></i>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);"
                    style="<?= $title == 'Course' || $title == 'Event' ? 'color: #4b94f7 ; background-color: #e2edfe' : '' ?>;">
                    <span class="icon-holder">
                        <i class="anticon anticon-project"
                            style="<?= $title == 'Course' || $title == 'Event' ? 'color: #4b94f7;' : '' ?>;"></i>
                    </span>
                    <span class="title">Activity</span>
                    <span class="arrow">
                        <i class="arrow-icon"></i>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?= url('courses') ?>">Course</a>
                    </li>
                    {{-- <li>
                        <a href="<?= url('events') ?>">Event</a>
                    </li> --}}
                </ul>
            </li>
            <?php if ((session('user')[0]['ID_ROLE']) == 1) { ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="<?= url('ebook') ?>"
                        style="<?= $title == 'Ebook' ? 'color: #4b94f7 ; background-color: #e2edfe' : '' ?>;">
                        <span class="icon-holder">
                            <i class="anticon anticon-book" style="<?= $title == 'Ebook' ? 'color: #4b94f7;' : '' ?>;"></i>
                        </span>
                        <span class="title">E-Book</span>
                        <span class="arrow">
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="<?= url('blogs') ?>"
                        style="<?= $title == 'Blog' ? 'color: #4b94f7 ; background-color: #e2edfe' : '' ?>;">
                        <span class="icon-holder">
                            <i class="anticon anticon-book" style="<?= $title == 'Blog' ? 'color: #4b94f7;' : '' ?>;"></i>
                        </span>
                        <span class="title">Blog</span>
                        <span class="arrow">
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);"
                        style="<?= $title == 'Promo' ? 'color: #4b94f7 ; background-color: #e2edfe' : '' ?>;">
                        <span class="icon-holder">
                            <i class="anticon anticon-project"
                                style="<?= $title == 'Promo' ? 'color: #4b94f7;' : '' ?>;"></i>
                        </span>
                        <span class="title">Promo</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?= url('promo') ?>">Discount Code</a>
                        </li>
                        <li>
                            <a href="<?= url('redeem-code') ?>">Private Code</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="<?= url('category') ?>"
                        style="<?= $title == 'Category' ? 'color: #4b94f7 ; background-color: #e2edfe' : '' ?>;">
                        <span class="icon-holder">
                            <i class="anticon anticon-gold"
                                style="<?= $title == 'Category' ? 'color: #4b94f7;' : '' ?>;"></i>
                        </span>
                        <span class="title">Category</span>
                        <span class="arrow">
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="<?= url('user') ?>"
                        style="<?= $title == 'User' ? 'color: #4b94f7 ; background-color: #e2edfe' : '' ?>;">
                        <span class="icon-holder">
                            <i class="anticon anticon-user" style="<?= $title == 'User' ? 'color: #4b94f7;' : '' ?>;"></i>
                        </span>
                        <span class="title">User</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="<?= url('send-email-verification') ?>"
                        style="<?= $title == 'Send Email Verif' ? 'color: #4b94f7 ; background-color: #e2edfe' : '' ?>;">
                        <span class="icon-holder">
                            <i class="anticon anticon-check" style="<?= $title == 'Send Email Verif' ? 'color: #4b94f7;' : '' ?>;"></i>
                        </span>
                        <span class="title">Verif Account</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="<?= url('instructor') ?>"
                        style="<?= $title == 'Instructor' ? 'color: #4b94f7 ; background-color: #e2edfe' : '' ?>;">
                        <span class="icon-holder">
                            <i class="anticon anticon-audit"
                                style="<?= $title == 'Instructor' ? 'color: #4b94f7;' : '' ?>;"></i>
                        </span>
                        <span class="title">Instructor</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<!-- Side Nav END -->

<!-- Page Container START -->
<div class="page-container">
