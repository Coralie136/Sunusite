<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<li class="sidebar-toggler-wrapper hide">
    <div class="sidebar-toggler">
        <span></span>
    </div>
</li>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
<li class="sidebar-search-wrapper">
    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
    <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
    <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
    <form class="sidebar-search  sidebar-search-bordered" action="" method="POST">
        <a href="javascript:;" class="remove">
            <i class="icon-close"></i>
        </a>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Rechercher...">
            <span class="input-group-btn">
                <a href="javascript:;" class="btn submit">
                    <i class="icon-magnifier"></i>
                </a>
            </span>
        </div>
    </form>
    <!-- END RESPONSIVE QUICK SEARCH FORM -->
</li>

    
<li class="nav-item start <?php echo $menu['article']['article']; ?>">
    <a href="<?php echo site_url('admin/article'); ?>" class="nav-link nav-toggle">
        <i class="fa fa-newspaper-o"></i>
        <span class="title">Articles</span>
    </a>
</li>

<li class="nav-item start <?php echo (!empty($menu['chiffre_cle']) ? $menu['chiffre_cle']['chiffre_cle'] : ''); ?>">
    <a href="<?php echo site_url('admin/chiffrecle'); ?>" class="nav-link nav-toggle">
        <i class="fa fa-money"></i>
        <span class="title">Chiffre clé</span>
    </a>
</li>

<li class="nav-item <?php echo $menu['post']['post']; ?>">
    <a href="<?php echo site_url('admin/post'); ?>" class="nav-link nav-toggle">
        <i class="fa fa-rss"></i>
        <span class="title">Publications</span>
    </a>
</li> 

<li class="nav-item <?php echo $menu['monbonprofil']; ?>">
    <a href="<?php echo site_url('admin/monbonprofil'); ?>" class="nav-link nav-toggle">
        <i class="fa fa-users"></i>
        <span class="title">Mon Bon Profil</span>
    </a>
</li>

<li class="heading">
    <h3 class="uppercase"> Notre réseau </h3>
</li>

<li class="nav-item start <?php echo (!empty($menu['pays']) ? $menu['pays']['pays'] : ''); ?>">
    <a href="<?php echo site_url('admin/pays'); ?>" class="nav-link nav-toggle">
        <i class="fa fa-flag"></i>
        <span class="title">Pays</span>
    </a>
</li>

<li class="nav-item start <?php echo (!empty($menu['filiale']) ? $menu['filiale']['filiale'] : ''); ?>">
    <a href="<?php echo site_url('admin/filiale'); ?>" class="nav-link nav-toggle">
        <i class="fa fa-home"></i>
        <span class="title">Filiale</span>
    </a>
</li>

<li class="heading">
    <h3 class="uppercase"> Le groupe </h3>
</li>

<li class="nav-item <?php echo $menu['group']['history']; ?>">
    <a href="<?php echo site_url('admin/group/history'); ?>" class="nav-link nav-toggle">
        <i class="fa fa-rotate-left"></i>
        <span class="title">Historique</span>
    </a>
</li>

<li class="nav-item <?php echo $menu['group']['text']; ?>">
    <a href="<?php echo site_url('admin/group/text'); ?>" class="nav-link nav-toggle">
        <i class="icon-speech"></i>
        <span class="title">Textes</span>
    </a>
</li>

<li class="nav-item <?php echo $menu['group']['director']; ?>">
    <a href="<?php echo site_url('admin/group/director'); ?>" class="nav-link nav-toggle">
        <i class="icon-user"></i>
        <span class="title">Directeur</span>
    </a>
</li>


<li class="nav-item <?php echo $menu['group']['team']; ?>">
    <a href="<?php echo site_url('admin/group/team'); ?>" class="nav-link nav-toggle">
        <i class="fa fa-group"></i>
        <span class="title">&Eacute;quipe</span>
    </a>
</li>


<li class="nav-item <?php echo (!empty($menu['group']['network']) ? $menu['group']['network'] : ''); ?>">
    <a href="<?php echo site_url('admin/group/network'); ?>" class="nav-link nav-toggle">
        <i class="fa fa-group"></i>
        <span class="title">Réseau social</span>
    </a>
</li>


<li class="nav-item <?php echo (!empty($menu['contact']) ? $menu['contact']['contact'] : ''); ?>">
    <a href="<?php echo site_url('admin/contact'); ?>" class="nav-link nav-toggle">
        <i class="fa fa-list-alt"></i>
        <span class="title">Administrateurs filiales</span>
    </a>
</li>

<li class="heading">
    <h3 class="uppercase"> Images </h3>
</li>


<li class="nav-item start <?php echo (!empty($menu['image']) ? $menu['image']['slider'] : ''); ?>">
    <a href="<?php echo site_url('admin/slider'); ?>" class="nav-link nav-toggle">
        <i class="fa fa-sliders"></i>
        <span class="title">Slider</span>
    </a>
</li>

<li class="nav-item start <?php echo (!empty($menu['image']) ? $menu['image']['image'] : ''); ?>">
    <a href="<?php echo site_url('admin/imagesite'); ?>" class="nav-link nav-toggle">
        <i class="fa fa-image"></i>
        <span class="title">Autre page</span>
    </a>
</li>
