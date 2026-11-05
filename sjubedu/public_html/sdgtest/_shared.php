<?php
/* ── SDG data ── */
$SDG = [
  1  => ['title'=>'No Poverty',                          'color'=>'#E5243B','icon'=>'🏘️','short'=>'End poverty in all its forms everywhere.'],
  2  => ['title'=>'Zero Hunger',                         'color'=>'#DDA63A','icon'=>'🌾','short'=>'End hunger, achieve food security and promote sustainable agriculture.'],
  3  => ['title'=>'Good Health & Well-being',            'color'=>'#4C9F38','icon'=>'❤️','short'=>'Ensure healthy lives and promote well-being for all at all ages.'],
  4  => ['title'=>'Quality Education',                   'color'=>'#C5192D','icon'=>'📚','short'=>'Ensure inclusive, equitable quality education and lifelong learning.'],
  5  => ['title'=>'Gender Equality',                     'color'=>'#FF3A21','icon'=>'⚧️','short'=>'Achieve gender equality and empower all women and girls.'],
  6  => ['title'=>'Clean Water & Sanitation',            'color'=>'#26BDE2','icon'=>'💧','short'=>'Ensure availability and sustainable management of water and sanitation.'],
  7  => ['title'=>'Affordable & Clean Energy',           'color'=>'#FCC30B','icon'=>'☀️','short'=>'Ensure access to affordable, reliable, sustainable and modern energy.'],
  8  => ['title'=>'Decent Work & Economic Growth',       'color'=>'#A21942','icon'=>'📈','short'=>'Promote inclusive economic growth, employment and decent work.'],
  9  => ['title'=>'Industry, Innovation & Infrastructure','color'=>'#FD6925','icon'=>'🔬','short'=>'Build resilient infrastructure and foster innovation.'],
  10 => ['title'=>'Reduced Inequalities',                'color'=>'#DD1367','icon'=>'🤝','short'=>'Reduce inequality within and among countries.'],
  11 => ['title'=>'Sustainable Cities & Communities',    'color'=>'#FD9D24','icon'=>'🏙️','short'=>'Make cities inclusive, safe, resilient and sustainable.'],
  12 => ['title'=>'Responsible Consumption & Production','color'=>'#BF8B2E','icon'=>'♻️','short'=>'Ensure sustainable consumption and production patterns.'],
  13 => ['title'=>'Climate Action',                      'color'=>'#3F7E44','icon'=>'🌍','short'=>'Take urgent action to combat climate change and its impacts.'],
  14 => ['title'=>'Life Below Water',                    'color'=>'#0A97D9','icon'=>'🐠','short'=>'Conserve and sustainably use oceans, seas and marine resources.'],
  15 => ['title'=>'Life on Land',                        'color'=>'#56C02B','icon'=>'🌿','short'=>'Protect, restore and promote sustainable use of terrestrial ecosystems.'],
  16 => ['title'=>'Peace, Justice & Strong Institutions','color'=>'#00689D','icon'=>'⚖️','short'=>'Promote peaceful and inclusive societies and strong institutions.'],
  17 => ['title'=>'Partnerships for the Goals',          'color'=>'#19486A','icon'=>'🌐','short'=>'Strengthen the means of implementation and revitalize global partnerships.'],
];

/* ── SJU contributions per goal ── */
$SJU_CONTRIB = [
  1  => ['tags'=>['Merit-cum-Means Scholarships','Government Schemes','BSW/MSW'],
         'detail'=>'SJU provides need-based scholarships, freeship seats, and direct fee concessions ensuring higher education is accessible to students from economically weaker sections. The BSW and MSW programmes train social workers to fight poverty at the grassroots.'],
  2  => ['tags'=>['Mid-Day Meal Programme','Life Sciences Research','Urban Agriculture'],
         'detail'=>'The campus Mid-Day Meal programme ensures no student goes hungry. The Department of Life Sciences engages in food-security research and urban-agriculture awareness initiatives.'],
  3  => ['tags'=>['Student Counselling','NSS Health Camps','Mental Health Week'],
         'detail'=>'A dedicated counselling centre, sports infrastructure, mental-health awareness campaigns, and NSS medical camps extend physical and psychological well-being support beyond the classroom.'],
  4  => ['tags'=>['NAAC A+','NEP 2020','60+ Programmes','Open Electives'],
         'detail'=>'NAAC-accredited with A+ grade, SJU offers 60+ UG, PG, and PhD programmes aligned with NEP 2020. Industry-integrated curricula, open electives, and experiential learning are central to the pedagogy.'],
  5  => ['tags'=>['Equal Opportunity Cell','Women\'s Cell','Gender Champions'],
         'detail'=>'The Equal Opportunity Cell, Gender Champions programme, and Women\'s Cell actively promote gender equity on campus and in surrounding communities through workshops and inclusive policy frameworks.'],
  6  => ['tags'=>['Rainwater Harvesting','Water Audits','Environmental Science'],
         'detail'=>'Rainwater harvesting systems across campus, annual water-audit programmes, and Environmental Science student projects on watershed management and water-quality testing contribute to this goal.'],
  7  => ['tags'=>['Solar Campus','Energy Audits','Physics Research'],
         'detail'=>'Solar panels installed across campus buildings reduce the carbon footprint. Physics and Electronics departments conduct research on renewable energy systems, smart grids, and energy efficiency.'],
  8  => ['tags'=>['Placement Cell','SJRIC Incubation','Entrepreneurship Cell'],
         'detail'=>'The Career Development Centre places students across 200+ companies annually. The SJRIC incubates student start-ups and the Entrepreneurship Cell fosters the next generation of job creators.'],
  9  => ['tags'=>['M.Sc. Cyber Security & AI','Industry MoUs','Research Centres'],
         'detail'=>'State-of-the-art labs in Cyber Security, AI, Bioinformatics, and Data Analytics. MoUs with industry partners facilitate collaborative research, internships, and technology transfer.'],
  10 => ['tags'=>['Shift III Programmes','SC/ST Scholarships','First-Gen Outreach'],
         'detail'=>'Reservation policies, SC/ST/OBC scholarships, Shift III evening programmes for working students, and dedicated outreach to first-generation learners actively reduce access gaps in higher education.'],
  11 => ['tags'=>['Green Campus','Urban Community Projects','NSS Outreach'],
         'detail'=>'Green-campus architecture, community outreach in Bengaluru neighbourhoods, and urban-studies modules in Social Work and Economics contribute to city sustainability and inclusive communities.'],
  12 => ['tags'=>['Plastic-Free Campus','Waste Segregation','Composting'],
         'detail'=>'Zero single-use plastic policy, segregated waste management, composting of food waste from the canteen, and annual sustainability audits across all departments drive responsible consumption.'],
  13 => ['tags'=>['Climate Clock','M.Sc. Environmental Science','Tree Plantation'],
         'detail'=>'SJU hosts a live Climate and World Clock, runs a dedicated M.Sc. in Environmental Science & Sustainability, and leads student-driven climate-awareness campaigns and tree-planting drives.'],
  14 => ['tags'=>['Aquatic Biodiversity Research','Zoology Department','Field Studies'],
         'detail'=>'Zoology and Environmental Science research on freshwater biodiversity, student field studies in aquatic ecosystems, and awareness campaigns against water body pollution address this goal.'],
  15 => ['tags'=>['Botanical Garden','Biodiversity Audit','Herbarium'],
         'detail'=>'A thriving botanical garden on campus, biodiversity audits, herbarium collections, and Botany & Zoology research programmes focused on native species conservation serve this goal.'],
  16 => ['tags'=>['IQAC Governance','Grievance Cell','Journalism Dept'],
         'detail'=>'Legal-awareness clinics, IQAC-driven institutional governance, anti-ragging and grievance redressal committees, and the Department of Journalism fostering media literacy and free expression.'],
  17 => ['tags'=>['International MoUs','ACU Member','Jesuit Network'],
         'detail'=>'Active MoUs with international universities, NGOs, government bodies, and industry partners globally. Member of ACU, Jesuit Worldwide Learning, and engaged with the NIRF framework.'],
];

/* ── Shared CSS ── */
function sdg_head_css() { ?>
<style>
:root{--sdg1:#E5243B;--sdg2:#DDA63A;--sdg3:#4C9F38;--sdg4:#C5192D;--sdg5:#FF3A21;--sdg6:#26BDE2;--sdg7:#FCC30B;--sdg8:#A21942;--sdg9:#FD6925;--sdg10:#DD1367;--sdg11:#FD9D24;--sdg12:#BF8B2E;--sdg13:#3F7E44;--sdg14:#0A97D9;--sdg15:#56C02B;--sdg16:#00689D;--sdg17:#19486A;}
.sdg-badge{display:inline-block;font-size:.7rem;font-weight:700;color:#fff;padding:2px 9px;border-radius:20px;margin:2px;}
.section-accent{width:48px;height:4px;background:#2563b0;border-radius:2px;margin:0 auto 12px;}
.sdg-pill-tag{display:inline-block;font-size:.74rem;font-weight:600;padding:3px 10px;border-radius:20px;background:#f1f5f9;color:#334155;margin:2px;}
</style>
<?php }
