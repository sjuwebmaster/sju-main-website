<?php
// Shared SDG sub-navigation
$sdg_nav = [
  'index.php'        => ['icon'=>'bi-house-fill',        'label'=>'Overview'],
  'our-goals.php'    => ['icon'=>'bi-bullseye',           'label'=>'Our Goals'],
  'initiatives.php'  => ['icon'=>'bi-people-fill',        'label'=>'Initiatives'],
  'research.php'     => ['icon'=>'bi-journal-richtext',   'label'=>'Research'],
  'reports.php'      => ['icon'=>'bi-file-earmark-bar-graph-fill', 'label'=>'Reports'],
  'get-involved.php' => ['icon'=>'bi-hand-thumbs-up-fill','label'=>'Get Involved'],
];
$current = basename($_SERVER['PHP_SELF']);
?>
<nav class="sdg-subnav py-2" style="background:#1a3c6e;z-index:8;box-shadow:0 2px 12px rgba(0,0,0,.18);position:sticky;top:0;">
  <div class="container">
    <div class="d-flex align-items-center gap-1 overflow-auto sdg-subnav-inner" style="-webkit-overflow-scrolling:touch;">
      <span class="text-white fw-bold me-3 text-nowrap" style="font-size:.82rem;opacity:.7;letter-spacing:.06em;">SDGs</span>
      <?php foreach ($sdg_nav as $page => $item): ?>
      <a href="<?= $page ?>" class="sdg-subnav-link text-nowrap <?= $current===$page ? 'active' : '' ?>">
        <i class="bi <?= $item['icon'] ?>"></i> <?= $item['label'] ?>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</nav>
<style>
.sdg-subnav-inner { scrollbar-width: none; }
.sdg-subnav-inner::-webkit-scrollbar { display: none; }
.sdg-subnav-link {
  color: rgba(255,255,255,.72); text-decoration: none;
  padding: 6px 14px; border-radius: 20px;
  font-size: .82rem; font-weight: 600;
  transition: background .15s, color .15s;
  display: flex; align-items: center; gap: 5px;
}
.sdg-subnav-link:hover { background: rgba(255,255,255,.12); color: #fff; }
.sdg-subnav-link.active { background: #fff; color: #1a3c6e; }
</style>
