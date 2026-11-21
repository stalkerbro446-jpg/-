<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// ============================================================================
// CORE
// ============================================================================
class Storage {
    const VERSION = '2026-11-21c'; // меняй при изменении seed(): данные в сессии пересоздадутся
    public static function init(): void {
        if (!isset($_SESSION['data']) || ($_SESSION['seed_v'] ?? '') !== self::VERSION) {
            $_SESSION['data'] = self::seed();
            $_SESSION['seed_v'] = self::VERSION;
        }
    }
    public static function &get(): array { return $_SESSION['data']; }
    private static function seed(): array {
        return [
            'users' => [
                1 => ['id'=>1,'name'=>'Админ','role'=>'admin','login'=>'admin','password'=>password_hash('admin', PASSWORD_DEFAULT),'created_at'=>'2025-09-01 10:00'],
                2 => ['id'=>2,'name'=>'Редактор','role'=>'editor','login'=>'editor','password'=>password_hash('editor', PASSWORD_DEFAULT),'created_at'=>'2025-09-01 10:00'],
                3 => ['id'=>3,'name'=>'Читатель','role'=>'user','login'=>'user','password'=>password_hash('user', PASSWORD_DEFAULT),'created_at'=>'2025-09-01 10:00'],
            ],
            'categories' => [
                1 => ['id'=>1,'name'=>'Спорт'],
                2 => ['id'=>2,'name'=>'Наука'],
                3 => ['id'=>3,'name'=>'Технологии'],
                4 => ['id'=>4,'name'=>'Образование'],
            ],
            'news' => [
                // 1. Спорт
                1 => ['id'=>1,'title'=>'Историческая победа в финале чемпионата','short'=>'Наша сборная вырвала победу в последние минуты матча.','body'=>'В захватывающем финале наша сборная одержала победу со счётом 3:2. Матч держал в напряжении всех болельщиков до последней секунды...','author'=>'Редактор','author_id'=>2,'category_id'=>1,'status'=>'published','published_at'=>'2025-11-20 19:00', 'image'=>'art:sport'],
                
                // 2. Технологии (Rust 1.100)
                2 => ['id'=>2,'title'=>'Вышел Rust 1.100: юбилейный релиз и ускорение компиляции','short'=>'Сотый стабильный выпуск языка получил новые возможности Cargo, а параллельный фронтенд в nightly ускорил cargo check почти вдвое.','body'=>'12 ноября 2026 года вышел Rust 1.100.0 — сотый выпуск после версии 1.0. Cargo теперь предупреждает о зависимостях, которые указаны в манифесте, но не используются, а ещё получил настройку «периода охлаждения»: при выборе версий пропускаются пакеты, опубликованные совсем недавно, ведь вредоносные версии обычно находят в первые часы и дни после публикации.

16 ноября команда компилятора сообщила, что параллельный фронтенд (проверка типов и заимствований) включён в ночных сборках по умолчанию. Для отдельного крейта время cargo check сокращается в среднем на 22% при двух потоках и на 44% при восьми. В стабильной версии фронтенд пока последовательный, а для полной проверки проекта выигрыш скромнее — около 15%.

Rust по-прежнему выбирают там, где раньше писали на C и C++: в системных утилитах, сетевых сервисах и встраиваемых устройствах. Следующий стабильный выпуск, 1.101, ожидается в конце декабря.','author'=>'Редактор','author_id'=>2,'category_id'=>3,'status'=>'published','published_at'=>'2026-11-16 17:00', 'image'=>'art:rust'],
                
                // 3. Наука (новый вид кошек; 6 — каннибал-инфузория)
                3 => ['id'=>3,'title'=>'В Боливии открыли новый вид диких кошек — впервые за сто лет','short'=>'Leopardus tilcayo обитает в лесах Юнгас на склонах Анд и отделился от родственных линий около 1,4 млн лет назад.','body'=>'Учёные описали новый вид небольших пятнистых кошек — Leopardus tilcayo. Он живёт в лесном регионе Юнгас на восточных склонах Анд. Всё началось с того, что биолог Паола Ногалес-Аскарсунс обратила внимание на необычный облик животного: небольшую морду, короткие округлые уши и крупные пятна, напоминающие леопардовый окрас.

Окончательно установить происхождение помог анализ геномов: исследователи сравнили полные геномы 38 представителей рода Leopardus и выяснили, что новый вид генетически отличается от других тигровых кошек.

Вид Leopardus tigrinus, описанный ещё в 1775 году, давно требовал пересмотра: учёные подозревали, что под этим названием скрывается как минимум четыре вида. Заодно выделили и новый подвид из Перу — Leopardus tigrinus antisuyo. Пока все эти кошки числились одним видом, казалось, что их много, но это могло быть иллюзией, поэтому теперь каждый вид нужно оценивать отдельно с точки зрения охраны.','author'=>'Редактор','author_id'=>2,'category_id'=>2,'status'=>'published','published_at'=>'2026-09-18 15:14', 'image'=>'art:cat'],
                
                // 4. Образование (нейросеть для школ)
                4 => ['id'=>4,'title'=>'Минпросвещения и Сбербанк создадут нейросеть для школ','short'=>'Суверенная модель ИИ дополнит работу учителя, а курс по ИИ уже прошли более 250 тысяч педагогов.','body'=>'15 ноября на стратегической сессии «Искусственный интеллект в образовании: единый учебный контур» в московской «Школе 21» подписали соглашение между Министерством просвещения и Сбербанком. Оно предусматривает совместную работу над моделью искусственного интеллекта для системы общего образования. В мероприятии участвовали более 100 человек из 20 регионов.

Министр просвещения Сергей Кравцов подчеркнул, что нейросеть появится в дополнение к традиционной системе и работе учителя, а не вместо них. К программе повышения квалификации «Искусственный интеллект в работе учителя» уже присоединились более 250 тысяч педагогов. Вице-премьер Дмитрий Чернышенко отметил, что освободившееся время учителя должны потратить на общение с учениками.

Победитель конкурса «Учитель года России — 2026» Алексей Морозов, преподающий информатику в тверской гимназии № 12, сказал, что тестируемая платформа хорошо справляется с обработкой и анализом контента, но вопросам этической верификации нужно уделить отдельное внимание.','author'=>'Редактор','author_id'=>2,'category_id'=>4,'status'=>'published','published_at'=>'2026-11-15 12:00', 'image'=>'art:edu'],
                6 => ['id'=>6,'title'=>'Одноклеточный организм научился превращаться в каннибала-сверхгиганта','short'=>'Инфузория Euplotes gigatrox охотится на собственных клонов — это редкий пример сложного развития внутри одной клетки.','body'=>'Исследователи из Политехнического института Ренселера (США) описали новый вид инфузорий Euplotes gigatrox, найденный в системе фильтрации морской воды на острове Кюрасао. В колонии клонов, где у всех клеток одинаковая ДНК, отдельные клетки спонтанно превращаются в «сверхгигантов»: они вырастают с 54 до примерно 140 микрометров, становятся шире и получают более крупный рот.

Вместо того чтобы фильтровать бактерии, сверхгиганты становятся хищниками и проглатывают своих меньших сородичей целиком — примерно по одной клетке каждые десять минут. Они лучше охотятся, но хуже плавают. Доля сверхгигантов в популяции не превышала пяти процентов, а после превращения обратно клетки некоторое время несут особый набор молекул, подавляющий новое превращение.

Работа опубликована в журнале PNAS. По словам биолога Бена Ларсона, одна клетка здесь делает то, что обычно связывают с развитием животных.','author'=>'Редактор','author_id'=>2,'category_id'=>2,'status'=>'published','published_at'=>'2026-06-02 12:00', 'image'=>'art:cell'],
                
                // 5. Черновик
                5 => ['id'=>5,'title'=>'Открытие нового корпуса университета','short'=>'Современные лаборатории и аудитории для студентов.','body'=>'В торжественной обстановке был открыт новый корпус, оснащенный по последнему слову техники...','author'=>'Редактор','author_id'=>2,'category_id'=>4,'status'=>'draft','published_at'=>null, 'image'=>'art:uni'],
            ],
            'comments' => [
                1 => ['id'=>1,'news_id'=>1,'user_id'=>3,'text'=>'Отличная новость, поздравляю!','created_at'=>'2025-11-20 20:15'],
                2 => ['id'=>2,'news_id'=>2,'user_id'=>3,'text'=>'Параллельный фронтенд — отличная новость, cargo check действительно бывает долгим.','created_at'=>'2025-12-24 14:00'],
                3 => ['id'=>3,'news_id'=>3,'user_id'=>3,'text'=>'Невероятно, что в наше время ещё находят новые виды кошек!','created_at'=>'2026-03-29 09:12'],
            ],
            'counters' => ['users'=>4,'categories'=>5,'news'=>7,'comments'=>4],
        ];
    }
}

class Auth {
    public static function login(int $userId): void { session_regenerate_id(true); $_SESSION['user_id'] = $userId; }
    public static function logout(): void { unset($_SESSION['user_id']); }
    public static function user(): ?array {
        $uid = $_SESSION['user_id'] ?? null;
        return $uid ? (Storage::get()['users'][$uid] ?? null) : null;
    }
    public static function canEdit(): bool { return in_array(self::user()['role'] ?? null, ['admin','editor'], true); }
    public static function isAdmin(): bool { return (self::user()['role'] ?? null) === 'admin'; }
    public static function canDelete(): bool { return (self::user()['role'] ?? null) === 'admin'; }
}

class Registry {
    private static array $map = [];
    public static function set(string $n, $o): void { self::$map[$n] = $o; }
    public static function get(string $n) {
        if (!isset(self::$map[$n])) throw new RuntimeException("Модуль '$n' не найден");
        return self::$map[$n];
    }
    public static function has(string $n): bool { return isset(self::$map[$n]); }
}

function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function redirect(string $url): void { header('Location: '.$url); exit; }
function flash(string $msg): void { $_SESSION['flash'] = $msg; }

// Встроенные иллюстрации (SVG): работают без интернета. В поле «image» пишется art:ключ
function art(string $k): string {
    $head = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 520">';
    switch ($k) {
        case 'sport':
            $b = '<defs><linearGradient id="g" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#0f2a1d"/><stop offset="1" stop-color="#1f6b45"/></linearGradient></defs>'
              . '<rect width="800" height="520" fill="url(#g)"/>'
              . '<g stroke="#fff6c8" stroke-opacity=".10" stroke-width="46"><path d="M160 80L60 520"/><path d="M640 80L740 520"/></g>'
              . '<g fill="#fff6c8"><circle cx="140" cy="70" r="11"/><circle cx="182" cy="70" r="11"/><circle cx="618" cy="70" r="11"/><circle cx="660" cy="70" r="11"/></g>'
              . '<path d="M0 330H800V520H0z" fill="#2c8a57"/>'
              . '<g fill="#37a064"><path d="M0 330H800V360H0z"/><path d="M0 400H800V440H0z"/><path d="M0 480H800V520H0z"/></g>'
              . '<g fill="none" stroke="#e9f7ee" stroke-width="3" opacity=".85"><path d="M60 520L250 330H550L740 520"/><circle cx="400" cy="440" r="60"/><path d="M400 330V520"/></g>'
              . '<circle cx="400" cy="250" r="64" fill="#fafafa"/><path d="M400 214l34 25-13 40h-42l-13-40z" fill="#222"/>'
              . '<g stroke="#222" stroke-width="4"><path d="M400 214V190"/><path d="M434 239l26-11"/><path d="M421 279l17 23"/><path d="M379 279l-17 23"/><path d="M366 239l-26-11"/></g>';
            break;
        case 'rust':
            $b = '<defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#1c1917"/><stop offset="1" stop-color="#4a2410"/></linearGradient></defs>'
              . '<rect width="800" height="520" fill="url(#g)"/>'
              . '<rect x="110" y="70" width="580" height="330" rx="16" fill="#151210" stroke="#4a3f36" stroke-width="2"/>'
              . '<circle cx="140" cy="100" r="7" fill="#ff5f56"/><circle cx="164" cy="100" r="7" fill="#ffbd2e"/><circle cx="188" cy="100" r="7" fill="#27c93f"/>'
              . '<g font-family="Consolas,Menlo,monospace" font-size="24">'
              . '<text x="150" y="170" fill="#c678dd">fn <tspan fill="#61afef">main</tspan><tspan fill="#abb2bf">() {</tspan></text>'
              . '<text x="190" y="215" fill="#e5c07b">let <tspan fill="#abb2bf">v = </tspan><tspan fill="#98c379">vec!</tspan><tspan fill="#abb2bf">[1, 2, 3];</tspan></text>'
              . '<text x="190" y="260" fill="#61afef">println!<tspan fill="#abb2bf">(</tspan><tspan fill="#98c379">"{}"</tspan><tspan fill="#abb2bf">, v.len());</tspan></text>'
              . '<text x="150" y="305" fill="#abb2bf">}</text>'
              . '<text x="150" y="350" fill="#5c6370">// cargo check</text></g>'
              . '<g fill="none" stroke="#dea584"><circle cx="610" cy="360" r="62" stroke-width="22" stroke-dasharray="15 11"/><circle cx="610" cy="360" r="44" stroke-width="10"/><circle cx="610" cy="360" r="14" stroke-width="8"/></g>'
              . '<text x="110" y="480" font-family="Georgia,serif" font-size="64" font-weight="700" fill="#dea584">1.100</text>';
            break;
        case 'cat':
            $b = '<defs><linearGradient id="g" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#1b2a41"/><stop offset=".65" stop-color="#7a5c6e"/><stop offset="1" stop-color="#e0a96d"/></linearGradient></defs>'
              . '<rect width="800" height="520" fill="url(#g)"/>'
              . '<circle cx="640" cy="110" r="44" fill="#fff1c9" opacity=".92"/>'
              . '<g fill="#fff" opacity=".7"><circle cx="120" cy="80" r="2"/><circle cx="260" cy="50" r="2"/><circle cx="380" cy="110" r="2"/><circle cx="520" cy="60" r="2"/><circle cx="720" cy="190" r="2"/><circle cx="60" cy="190" r="2"/></g>'
              . '<path d="M0 330L130 220L240 300L380 180L520 290L650 200L800 310V520H0z" fill="#3b3550"/>'
              . '<path d="M0 400L110 320L220 390L340 300L470 390L600 310L800 400V520H0z" fill="#26283a"/>'
              . '<g fill="#10151f"><path d="M40 520l30-120 30 120z"/><path d="M110 520l24-90 24 90z"/><path d="M690 520l30-130 30 130z"/><path d="M750 520l22-84 22 84z"/></g>'
              . '<path d="M90 400Q400 350 720 410" fill="none" stroke="#0b0d12" stroke-width="16" stroke-linecap="round"/>'
              . '<g fill="#0b0d12"><ellipse cx="430" cy="352" rx="82" ry="40"/><circle cx="520" cy="312" r="35"/><path d="M494 290l5-34 24 24zM526 282l22-28 4 36z"/>'
              . '<rect x="380" y="372" width="16" height="36" rx="8"/><rect x="450" y="376" width="16" height="32" rx="8"/></g>'
              . '<path d="M352 356Q285 352 282 296Q280 266 306 262" fill="none" stroke="#0b0d12" stroke-width="15" stroke-linecap="round"/>'
              . '<g fill="#ffd166"><circle cx="508" cy="311" r="4.5"/><circle cx="533" cy="311" r="4.5"/></g>';
            break;
        case 'cell':
            $b = '<defs><radialGradient id="g" cx=".5" cy=".5" r=".8"><stop offset="0" stop-color="#103a63"/><stop offset="1" stop-color="#050f1f"/></radialGradient></defs>'
              . '<rect width="800" height="520" fill="url(#g)"/>'
              . '<g fill="none" stroke="#7ee0c9" stroke-opacity=".5"><ellipse cx="150" cy="140" rx="46" ry="28" stroke-width="2"/><ellipse cx="660" cy="150" rx="42" ry="26" stroke-width="2"/><ellipse cx="130" cy="400" rx="44" ry="26" stroke-width="2"/><ellipse cx="670" cy="410" rx="46" ry="28" stroke-width="2"/><ellipse cx="205" cy="290" rx="38" ry="24" stroke-width="2"/></g>'
              . '<g fill="#7ee0c9" fill-opacity=".12"><ellipse cx="150" cy="140" rx="46" ry="28"/><ellipse cx="660" cy="150" rx="42" ry="26"/><ellipse cx="130" cy="400" rx="44" ry="26"/><ellipse cx="670" cy="410" rx="46" ry="28"/><ellipse cx="205" cy="290" rx="38" ry="24"/></g>'
              . '<ellipse cx="420" cy="260" rx="200" ry="125" fill="#7ee0c9" fill-opacity=".18" stroke="#7ee0c9" stroke-width="3"/>'
              . '<ellipse cx="420" cy="260" rx="212" ry="137" fill="none" stroke="#7ee0c9" stroke-width="16" stroke-dasharray="2 9" opacity=".75"/>'
              . '<ellipse cx="450" cy="250" rx="72" ry="42" fill="#d9a5ff" fill-opacity=".5" stroke="#e6c4ff" stroke-width="2"/>'
              . '<g fill="#fff" fill-opacity=".5"><circle cx="440" cy="245" r="5"/><circle cx="465" cy="258" r="6"/><circle cx="480" cy="238" r="4"/></g>'
              . '<ellipse cx="248" cy="270" rx="32" ry="20" fill="#050f1f" stroke="#7ee0c9" stroke-width="3"/>'
              . '<g fill="#fff" opacity=".35"><circle cx="330" cy="90" r="6"/><circle cx="560" cy="70" r="4"/><circle cx="400" cy="450" r="5"/><circle cx="560" cy="470" r="7"/><circle cx="90" cy="270" r="4"/></g>';
            break;
        case 'edu':
            $nodes = ''; $lines = '';
            $cols = [[230, [160, 235, 310]], [400, [125, 200, 275, 350]], [570, [200, 275]]];
            for ($c = 0; $c < 2; $c++) foreach ($cols[$c][1] as $y1) foreach ($cols[$c + 1][1] as $y2)
                $lines .= '<path d="M' . $cols[$c][0] . ' ' . $y1 . 'L' . $cols[$c + 1][0] . ' ' . $y2 . '"/>';
            foreach ($cols as [$x, $ys]) foreach ($ys as $y) $nodes .= '<circle cx="' . $x . '" cy="' . $y . '" r="13"/>';
            $b = '<defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#f6e7cf"/><stop offset="1" stop-color="#d7b58a"/></linearGradient></defs>'
              . '<rect width="800" height="520" fill="url(#g)"/>'
              . '<rect x="110" y="70" width="580" height="330" rx="16" fill="#24372f" stroke="#8b5e3c" stroke-width="14"/>'
              . '<g stroke="#9fd8c0" stroke-opacity=".5" stroke-width="2">' . $lines . '</g>'
              . '<g fill="#f6e7cf" stroke="#9fd8c0" stroke-width="3">' . $nodes . '</g>'
              . '<path d="M110 412H690" stroke="#8b5e3c" stroke-width="12" stroke-linecap="round"/>'
              . '<rect x="150" y="436" width="130" height="22" rx="4" fill="#b5835a"/><rect x="160" y="458" width="115" height="22" rx="4" fill="#6b6f4b"/><rect x="146" y="480" width="136" height="22" rx="4" fill="#8f3b2e"/>'
              . '<rect x="560" y="440" width="130" height="62" rx="12" fill="#fffdf9"/><path d="M590 502l-6 16 22-16z" fill="#fffdf9"/>'
              . '<g fill="#6b6f4b"><circle cx="595" cy="471" r="6"/><circle cx="625" cy="471" r="6"/><circle cx="655" cy="471" r="6"/></g>';
            break;
        default: // uni
            $w = '';
            for ($r = 0; $r < 3; $r++) for ($c = 0; $c < 5; $c++)
                $w .= '<rect x="' . (230 + $c * 70) . '" y="' . (230 + $r * 70) . '" width="38" height="44" rx="4"/>';
            $b = '<defs><linearGradient id="g" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#bfd4df"/><stop offset="1" stop-color="#f6e7cf"/></linearGradient></defs>'
              . '<rect width="800" height="520" fill="url(#g)"/>'
              . '<circle cx="660" cy="100" r="40" fill="#fff6d8"/>'
              . '<path d="M190 200L400 110L610 200z" fill="#6b6f4b"/><rect x="200" y="200" width="400" height="260" fill="#b5835a"/>'
              . '<g fill="#fff6d8">' . $w . '</g><rect x="372" y="390" width="56" height="70" rx="6" fill="#4a3426"/>'
              . '<rect x="0" y="460" width="800" height="60" fill="#8a9a5b"/>';
    }
    return $head . $b . '</svg>';
}

function role_label(string $r): string { return ['admin'=>'Администратор','editor'=>'Редактор','user'=>'Читатель'][$r] ?? $r; }

function cat_meta(int $id): array {
    static $m = [1=>['⚽','#2f6f4f'], 2=>['🔬','#3b5b9a'], 3=>['💻','#6a4c93'], 4=>['🎓','#b5835a']];
    return $m[$id] ?? ['📰','#666666'];
}
function img_url(?string $u, int $w = 800): string {
    $u = (string)$u;
    if (strpos($u, 'art:') === 0) return 'data:image/svg+xml;base64,' . base64_encode(art(substr($u, 4)));
    return (string)preg_replace('/w=\d+/', 'w=' . $w, $u);
}
// Обложка: градиент + эмодзи категории, поверх — картинка (если не загрузится, останется градиент)
function news_cover(array $n, string $cls = 'card-img'): string {
    [$emoji, $color] = cat_meta((int)($n['category_id'] ?? 0));
    $h = "<div class='cover $cls' style='--c:$color'><span class='cover-emoji'>$emoji</span>";
    if (!empty($n['image'])) {
        $w = $cls === 'hero-image' ? 1400 : 800;
        $h .= "<img src='" . e(img_url($n['image'], $w)) . "' alt='" . e($n['title']) . "' loading='lazy' referrerpolicy='no-referrer' onerror=\"this.remove()\">";
    }
    return $h . "</div>";
}
function news_card(array $n): string {
    $cat = Storage::get()['categories'][$n['category_id']] ?? null;
    $date = $n['published_at'] ? date('d.m.Y', strtotime($n['published_at'])) : '';
    return "<a class='card' href='?page=view&id={$n['id']}'>" . news_cover($n)
        . "<div class='card-body'><div class='card-meta'><span class='cat-tag'>" . e($cat['name'] ?? '—') . "</span><span>$date</span></div>"
        . "<h3>" . e($n['title']) . "</h3><p>" . e($n['short']) . "</p><span class='btn-link'>Читать →</span></div></a>";
}

Storage::init();

// ============================================================================
// MODELS
// ============================================================================
class UserModel {
    static function all(): array { return Storage::get()['users']; }
    static function find(int $id): ?array { return Storage::get()['users'][$id] ?? null; }
    static function findByLogin(string $l): ?array {
        foreach (Storage::get()['users'] as $u) if (mb_strtolower($u['login']) === mb_strtolower($l)) return $u;
        return null;
    }
    static function create(string $name, string $login, string $password, string $role): int {
        $d = &Storage::get();
        $id = $d['counters']['users']++;
        $d['users'][$id] = ['id'=>$id,'name'=>$name,'role'=>$role,'login'=>$login,'password'=>password_hash($password, PASSWORD_DEFAULT),'created_at'=>date('Y-m-d H:i')];
        return $id;
    }
    static function setRole(int $id, string $role): void { $d = &Storage::get(); if (isset($d['users'][$id])) $d['users'][$id]['role'] = $role; }
    static function delete(int $id): void { $d = &Storage::get(); unset($d['users'][$id]); }
}
class CategoryModel {
    static function all(): array { return Storage::get()['categories']; }
    static function find(int $id): ?array { return Storage::get()['categories'][$id] ?? null; }
    static function create(string $name): int {
        $d = &Storage::get();
        $id = $d['counters']['categories']++;
        $d['categories'][$id] = ['id'=>$id, 'name'=>$name];
        return $id;
    }
    static function countNewsIn(int $catId): int {
        return count(array_filter(Storage::get()['news'], fn($n)=>$n['category_id']===$catId));
    }
}
class NewsModel {
    static function all(): array { return Storage::get()['news']; }
    static function find(int $id): ?array { return Storage::get()['news'][$id] ?? null; }
    static function published(): array {
        return array_values(array_filter(Storage::get()['news'], fn($n)=>$n['status']==='published'));
    }
    static function byCategory(int $catId): array {
        return array_values(array_filter(Storage::get()['news'], fn($n)=>$n['category_id']===$catId && $n['status']==='published'));
    }
    static function create(array $data): int {
        $d = &Storage::get();
        $id = $d['counters']['news']++;
        $d['news'][$id] = array_merge($data, ['id'=>$id,'status'=>'draft','published_at'=>null,'author'=>Auth::user()['name'] ?? 'Аноним','author_id'=>Auth::user()['id'] ?? 0]);
        return $id;
    }
    static function update(int $id, array $data): void {
        $d = &Storage::get();
        if (isset($d['news'][$id])) $d['news'][$id] = array_merge($d['news'][$id], $data);
    }
    static function delete(int $id): void { $d = &Storage::get(); unset($d['news'][$id]); }
    static function publish(int $id): void {
        $d = &Storage::get();
        if (isset($d['news'][$id])) { $d['news'][$id]['status'] = 'published'; $d['news'][$id]['published_at'] = date('Y-m-d H:i'); }
    }
}
class CommentModel {
    static function forNews(int $nid): array {
        return array_values(array_filter(Storage::get()['comments'], fn($c)=>$c['news_id']===$nid));
    }
    static function add(int $nid, int $uid, string $t): int {
        $d = &Storage::get();
        $id = $d['counters']['comments']++;
        $d['comments'][$id] = ['id'=>$id,'news_id'=>$nid,'user_id'=>$uid,'text'=>$t,'created_at'=>date('Y-m-d H:i')];
        return $id;
    }
    static function delete(int $id): void { $d = &Storage::get(); unset($d['comments'][$id]); }
    static function deleteByNews(int $nid): void {
        $d = &Storage::get();
        foreach ($d['comments'] as $id => $c) if ($c['news_id'] === $nid) unset($d['comments'][$id]);
    }
}

// ============================================================================
// CONTROLLERS (HMVC)
// ============================================================================
class UsersController {
    const ROLES = ['admin','editor','user'];
    public function all(): array { return UserModel::all(); }
    public function find(int $id): ?array { return UserModel::find($id); }
    public function login(string $l, string $p): bool {
        $u = UserModel::findByLogin($l);
        if ($u && password_verify($p, $u['password'] ?? '')) { Auth::login($u['id']); return true; }
        return false;
    }
    private function validateNew(string $name, string $login, string $pass): void {
        if ($name === '' || mb_strlen($name) > 50) throw new RuntimeException("Введите имя (до 50 символов)");
        if (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $login)) throw new RuntimeException("Логин: 3–20 символов, латиница, цифры и _");
        if (mb_strlen($pass) < 6) throw new RuntimeException("Пароль должен быть не короче 6 символов");
        if (UserModel::findByLogin($login)) throw new RuntimeException("Такой логин уже занят");
    }
    public function register(string $name, string $login, string $pass): int {
        $this->validateNew($name, $login, $pass);
        return UserModel::create($name, $login, $pass, 'user');
    }
    public function create(string $name, string $login, string $pass, string $role): int {
        if (!Auth::isAdmin()) throw new RuntimeException("Нет прав");
        if (!in_array($role, self::ROLES, true)) throw new RuntimeException("Неизвестная роль");
        $this->validateNew($name, $login, $pass);
        return UserModel::create($name, $login, $pass, $role);
    }
    public function setRole(int $id, string $role): void {
        if (!Auth::isAdmin()) throw new RuntimeException("Нет прав");
        if (!in_array($role, self::ROLES, true)) throw new RuntimeException("Неизвестная роль");
        if (!UserModel::find($id)) throw new RuntimeException("Пользователь не найден");
        if ($id === Auth::user()['id']) throw new RuntimeException("Нельзя менять собственную роль");
        UserModel::setRole($id, $role);
    }
    public function delete(int $id): void {
        if (!Auth::isAdmin()) throw new RuntimeException("Нет прав");
        if (!UserModel::find($id)) throw new RuntimeException("Пользователь не найден");
        if ($id === Auth::user()['id']) throw new RuntimeException("Нельзя удалить самого себя");
        UserModel::delete($id);
    }
}
class CategoriesController {
    public function all(): array { return CategoryModel::all(); }
    public function find(int $id): ?array { return CategoryModel::find($id); }
    public function create(string $name): int {
        if (!Auth::canEdit()) throw new RuntimeException("Нет прав");
        return CategoryModel::create($name);
    }
}
class NewsController {
    public function all(): array { return NewsModel::all(); }
    public function published(): array { return NewsModel::published(); }
    public function find(int $id): ?array { return NewsModel::find($id); }
    public function byCategory(int $c): array { return NewsModel::byCategory($c); }
    public function create(array $d): int { if (!Auth::canEdit()) throw new RuntimeException("Нет прав"); return NewsModel::create($d); }
    public function update(int $id, array $d): void { if (!Auth::canEdit()) throw new RuntimeException("Нет прав"); NewsModel::update($id, $d); }
    public function delete(int $id): void {
        if (!Auth::canDelete()) throw new RuntimeException("Нет прав");
        NewsModel::delete($id);
        if (Registry::has('comments')) Registry::get('comments')->deleteByNews($id);
    }
    public function publish(int $id): void { if (!Auth::canEdit()) throw new RuntimeException("Нет прав"); NewsModel::publish($id); }
}
class CommentsController {
    public function forNews(int $nid): array { return CommentModel::forNews($nid); }
    public function add(int $nid, int $uid, string $t): int { return CommentModel::add($nid, $uid, $t); }
    public function delete(int $id): void { if (!Auth::canEdit()) throw new RuntimeException("Нет прав"); CommentModel::delete($id); }
    public function deleteByNews(int $nid): void { CommentModel::deleteByNews($nid); }
}

Registry::set('users', new UsersController());
Registry::set('categories', new CategoriesController());
Registry::set('news', new NewsController());
Registry::set('comments', new CommentsController());

// ============================================================================
// LAYOUT
// ============================================================================
function render_page(string $title, string $content): void {
    $user = Auth::user();
    ?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($title) ?> — Новостной портал</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root { --bg:#f5efe6; --paper:#fffdf9; --ink:#2a2823; --muted:#7b766b; --line:#e3d9c8; --olive:#6b6f4b; --olive-d:#4f5236; --sand:#e9dfcd; --accent:#b5835a; }
* { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body { font-family: 'Inter', system-ui, -apple-system, sans-serif; background: var(--bg); color: var(--ink); line-height: 1.65; min-height: 100vh; display: flex; flex-direction: column; }
a { color: inherit; text-decoration: none; }
img { max-width: 100%; }
.container { max-width: 1240px; margin: 0 auto; padding: 0 32px; width: 100%; }
h1, h2, h3, .serif { font-family: 'Cormorant Garamond', 'Playfair Display', Georgia, serif; font-weight: 600; color: var(--ink); line-height: 1.12; }
h1 { font-size: clamp(2.2rem, 4.2vw, 3.6rem); margin-bottom: 24px; }
h2 { font-size: clamp(1.7rem, 3vw, 2.5rem); margin: 32px 0 16px; }
h3 { font-size: 1.5rem; margin-bottom: 8px; }

/* ШАПКА */
header.site-header { position: sticky; top: 0; z-index: 100; background: rgba(245,239,230,.92); backdrop-filter: blur(10px); border-bottom: 1px solid var(--line); }
header.site-header .container { display: flex; align-items: center; justify-content: space-between; gap: 24px; height: 76px; }
.brand { font-family: 'Cormorant Garamond', Georgia, serif; font-size: 1.9rem; font-weight: 700; letter-spacing: .02em; }
.brand span { color: var(--olive); font-style: italic; font-weight: 500; }
.nav-main { display: flex; gap: 34px; }
.nav-main a { font-size: .92rem; color: var(--ink); position: relative; padding: 4px 0; }
.nav-main a::after { content: ''; position: absolute; left: 0; bottom: -2px; width: 0; height: 1px; background: var(--ink); transition: width .25s; }
.nav-main a:hover::after { width: 100%; }
.header-actions { display: flex; align-items: center; gap: 16px; font-size: .9rem; }
.user-name { font-weight: 600; } .user-role { font-size: .7rem; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); margin-left: 6px; }
.btn-outline { border: 1px solid var(--ink); padding: 8px 20px; border-radius: 40px; transition: .2s; }
.btn-outline:hover { background: var(--ink); color: var(--bg); }

/* КНОПКИ */
.btn, form.box button { display: inline-block; margin-top: 20px; padding: 14px 30px; background: var(--ink); color: var(--paper); border: none; border-radius: 40px; font: 500 .95rem 'Inter', sans-serif; cursor: pointer; transition: .2s; }
.btn:hover, form.box button:hover { background: var(--olive-d); }
.btn.secondary { background: transparent; color: var(--ink); border: 1px solid var(--ink); } .btn.secondary:hover { background: var(--ink); color: var(--paper); }
.btn.danger { background: #a8402f; } .btn.danger:hover { background: #8b3325; }
.btn.small { padding: 7px 16px; font-size: .8rem; margin-top: 8px; }
.btn.light { background: var(--paper); color: var(--ink); } .btn.light:hover { background: var(--sand); }

main { flex: 1; padding: 40px 0 80px; }

/* ОБЛОЖКИ */
.cover { position: relative; overflow: hidden; background: linear-gradient(135deg, var(--c, #888), #1e1e1e); }
.cover .cover-emoji { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; opacity: .55; }
.cover img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: transform .6s; }
a.card:hover .cover img, .tile:hover .cover img { transform: scale(1.06); }

/* ГЕРОЙ-СЛАЙДЕР */
.hero { display: grid; grid-template-columns: 1fr 1.05fr; gap: 64px; align-items: center; min-height: 560px; padding: 24px 0 8px; }
.hero-tags { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 28px; }
.tag { font-size: .78rem; border: 1px solid var(--ink); border-radius: 30px; padding: 4px 14px; }
.tag::before { content: '+ '; }
.hero-slides { position: relative; min-height: 290px; }
.hero-slide { display: none; animation: fade .6s; }
.hero-slide.active { display: block; }
.hero-slide h1 { margin-bottom: 18px; }
.hero-slide p { color: var(--muted); font-size: 1.08rem; max-width: 520px; }
.eyebrow { display: block; font-size: .78rem; text-transform: uppercase; letter-spacing: .12em; color: var(--olive); margin-bottom: 16px; font-weight: 600; }
.hero-nav { display: flex; gap: 18px; margin-top: 36px; font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; }
.hero-nav button { background: none; border: none; border-bottom: 2px solid transparent; color: var(--muted); cursor: pointer; font: inherit; padding: 2px 4px; }
.hero-nav button.active { color: var(--ink); border-color: var(--ink); }
.hero-art { position: relative; aspect-ratio: 800 / 520; border-radius: 28px; overflow: hidden; background: var(--sand); }
.hero-art .cover { position: absolute; inset: 0; opacity: 0; transition: opacity .7s; border-radius: 28px; }
.hero-art .cover.active { opacity: 1; }
@keyframes fade { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }

/* СЕКЦИИ */
.sec-head { display: flex; justify-content: space-between; align-items: flex-end; margin: 84px 0 30px; gap: 20px; flex-wrap: wrap; }
.sec-head h2 { margin: 0; }
.sec-head p { color: var(--muted); max-width: 420px; font-size: .95rem; }
.section-title { display: flex; align-items: center; gap: 16px; }
.section-title::after { content: ''; flex: 1; height: 1px; background: var(--line); }

/* ПЛИТКИ РУБРИК */
.tiles { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 22px; }
.tile .cover { aspect-ratio: 4/3; border-radius: 20px; }
.tile .t-name { display: flex; justify-content: space-between; margin-top: 14px; font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; font-weight: 600; }
.tile .t-name span { font: 400 .85rem 'Inter', sans-serif; color: var(--muted); align-self: center; }

/* АККОРДЕОН */
.how { background: var(--paper); border-radius: 28px; padding: 48px 56px; display: grid; grid-template-columns: 1fr 1.4fr; gap: 56px; margin-top: 84px; }
.how h2 { margin-top: 0; }
.how p.lead { color: var(--muted); }
details.acc { border-bottom: 1px solid var(--line); padding: 20px 0; }
details.acc summary { list-style: none; display: flex; gap: 20px; align-items: baseline; cursor: pointer; font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 600; }
details.acc summary::-webkit-details-marker { display: none; }
details.acc summary b { font-weight: 500; color: var(--olive); width: 36px; }
details.acc summary::after { content: '+'; margin-left: auto; font-family: 'Inter', sans-serif; font-weight: 300; }
details.acc[open] summary::after { content: '–'; }
details.acc p { margin: 12px 0 0 56px; color: var(--muted); }

/* КАРТОЧКИ */
.news-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 28px; }
.card { background: var(--paper); border-radius: 22px; overflow: hidden; display: flex; flex-direction: column; transition: transform .3s, box-shadow .3s; }
.card:hover { transform: translateY(-5px); box-shadow: 0 18px 40px rgba(60,50,30,.10); }
.card-img { height: 230px; flex-shrink: 0; }
.card-body { padding: 24px 26px 28px; flex: 1; display: flex; flex-direction: column; }
.card-meta { display: flex; justify-content: space-between; font-size: .78rem; color: var(--muted); margin-bottom: 12px; }
.cat-tag { color: var(--olive); font-weight: 600; text-transform: uppercase; letter-spacing: .08em; }
.card h3 { font-size: 1.6rem; }
.card p { color: var(--muted); font-size: .93rem; flex: 1; margin-bottom: 20px; }
.btn-link { align-self: flex-start; border: 1px solid var(--ink); border-radius: 30px; padding: 7px 22px; font-size: .85rem; transition: .2s; }
.card:hover .btn-link { background: var(--ink); color: var(--paper); }

/* РАССЫЛКА */
.newsletter { background: var(--olive); color: var(--paper); border-radius: 28px; padding: 64px; margin-top: 84px; display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center; }
.newsletter h2 { color: var(--paper); margin: 0; }
.newsletter p { opacity: .85; margin-top: 12px; }
.newsletter form { display: flex; gap: 12px; flex-wrap: wrap; }
.newsletter input { flex: 1; min-width: 200px; padding: 15px 22px; border-radius: 40px; border: none; font: 1rem 'Inter', sans-serif; background: var(--paper); }
.newsletter button { padding: 15px 30px; border-radius: 40px; border: 1px solid var(--paper); background: transparent; color: var(--paper); font: 500 .95rem 'Inter', sans-serif; cursor: pointer; }
.newsletter button:hover { background: var(--paper); color: var(--olive-d); }

/* ОСТАЛЬНОЕ */
.badge { display: inline-block; vertical-align: middle; padding: 4px 12px; border-radius: 20px; font: 600 .7rem 'Inter', sans-serif; text-transform: uppercase; letter-spacing: .06em; }
.badge.draft { background: #fbe9c8; color: #8a5a00; } .badge.pub { background: #e3ead0; color: #3f4a1e; }
.meta { color: var(--muted); font-size: .9rem; margin-bottom: 24px; }
.meta a { text-decoration: underline; text-underline-offset: 3px; }
.article-hero { height: 460px; border-radius: 28px; margin-bottom: 32px; }
.content-body { background: var(--paper); padding: 44px 52px; border-radius: 24px; margin-bottom: 28px; }
.content-body p { margin-bottom: 18px; font-size: 1.08rem; color: #3a372f; }
.content-body p.lead { font-family: 'Cormorant Garamond', serif; font-size: 1.7rem; line-height: 1.3; color: var(--ink); font-weight: 600; }
.comments { margin-top: 20px; }
.comment { background: var(--paper); padding: 22px 28px; border-radius: 18px; margin-bottom: 12px; }
.comment .date { color: var(--muted); font-size: .85rem; margin-left: 8px; }
.comment p { margin-top: 8px; }
form.box { background: var(--paper); padding: 36px; border-radius: 24px; max-width: 700px; margin-bottom: 28px; }
form.box label { display: block; font-weight: 500; margin: 18px 0 8px; font-size: .92rem; }
form.box input[type=text], form.box input[type=password], form.box textarea, form.box select { width: 100%; padding: 13px 18px; border: 1px solid var(--line); border-radius: 14px; font: 1rem 'Inter', sans-serif; background: var(--bg); }
form.box input:focus, form.box textarea:focus { outline: none; border-color: var(--olive); }
form.box textarea { min-height: 150px; resize: vertical; }
.actions { margin: 20px 0 32px; display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
.actions form { margin: 0; } .actions .btn, .actions button { margin-top: 0; }
.related-title { margin-top: 56px; }
.flash { background: #f3ecd2; border: 1px solid #e0d39b; color: #66571f; padding: 14px 22px; border-radius: 16px; margin-bottom: 28px; }
.empty { color: var(--muted); font-style: italic; padding: 40px; text-align: center; background: var(--paper); border-radius: 22px; }

/* ПОЛЬЗОВАТЕЛИ */
.table-wrap { overflow-x: auto; border-radius: 22px; margin-bottom: 32px; background: var(--paper); }
.users-table { width: 100%; border-collapse: collapse; }
.users-table th, .users-table td { padding: 14px 20px; text-align: left; border-bottom: 1px solid var(--line); font-size: .92rem; vertical-align: middle; }
.users-table th { font-size: .72rem; text-transform: uppercase; letter-spacing: .1em; color: var(--muted); background: var(--sand); }
.users-table tr:last-child td { border-bottom: none; }
.users-table form { display: flex; gap: 8px; align-items: center; margin: 0; }
.users-table select { padding: 7px 14px; border: 1px solid var(--line); border-radius: 30px; background: var(--bg); font: inherit; }
.users-table .btn { margin-top: 0; }
.role-pill { display: inline-block; padding: 4px 14px; border-radius: 30px; font-size: .78rem; font-weight: 600; }
.role-pill.admin { background: #e3ead0; color: #3f4a1e; } .role-pill.editor { background: #f3e3c8; color: #7a5424; } .role-pill.user { background: var(--sand); color: var(--muted); }

/* ПОДВАЛ */
footer { background: #24221d; color: #b4ad9f; padding: 72px 0 28px; font-size: .9rem; }
.footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.4fr; gap: 48px; margin-bottom: 48px; }
.footer-brand h4 { font: 700 1.8rem 'Cormorant Garamond', serif; color: #fff; margin-bottom: 14px; }
.footer-brand p { max-width: 320px; }
.footer-col h5 { color: #fff; font-size: .75rem; text-transform: uppercase; letter-spacing: .14em; margin-bottom: 20px; font-weight: 600; }
.footer-col ul { list-style: none; } .footer-col li { margin-bottom: 12px; } .footer-col a:hover { color: #fff; }
.footer-bottom { border-top: 1px solid #3a3730; padding-top: 24px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 12px; font-size: .8rem; color: #8a8478; }

@media (max-width: 960px) {
    .container { padding: 0 20px; }
    .hero { grid-template-columns: 1fr; gap: 28px; min-height: 0; }
    .hero-art { order: -1; }
    .how, .newsletter { grid-template-columns: 1fr; padding: 32px 26px; gap: 28px; }
    .footer-grid { grid-template-columns: 1fr 1fr; }
    .nav-main { gap: 18px; }
    header.site-header .container { height: auto; padding: 14px 20px; flex-wrap: wrap; }
    .content-body { padding: 26px 22px; } .article-hero { height: 260px; }
}
</style>
</head>
<body>

<header class="site-header">
    <div class="container">
        <a href="?page=home" class="brand">Новостной<span>Портал</span></a>
        <nav class="nav-main">
            <a href="?page=home">Главная</a>
            <a href="?page=categories">Рубрики</a>
            <?php if (Auth::canEdit()): ?><a href="?page=create">Создать</a><?php endif; ?>
            <?php if (Auth::isAdmin()): ?><a href="?page=users">Пользователи</a><?php endif; ?>
        </nav>
        <div class="header-actions">
            <?php if ($user): ?>
                <span><span class="user-name"><?= e($user['name']) ?></span><span class="user-role"><?= e(role_label($user['role'])) ?></span></span>
                <a href="?page=logout" class="btn-outline">Выйти</a>
            <?php else: ?>
                <a href="?page=register" style="font-size:.9rem">Регистрация</a>
                <a href="?page=login" class="btn-outline">Войти</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<main>
    <div class="container">
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="flash"><?= e($_SESSION['flash']) ?></div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
        <?= $content ?>
    </div>
</main>

<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <h4>Новостной Портал</h4>
                <p>Ежедневные новости, аналитика и мнения. Рассказываем о главном в науке, технологиях, образовании и спорте.</p>
            </div>
            <div class="footer-col">
                <h5>Разделы</h5>
                <ul><li><a href="?page=home">Главная</a></li><li><a href="?page=categories">Рубрики</a></li></ul>
            </div>
            <div class="footer-col">
                <h5>Информация</h5>
                <ul><li><a href="#">О проекте</a></li><li><a href="#">Контакты</a></li><li><a href="#">Реклама</a></li></ul>
            </div>
            <div class="footer-col">
                <h5>Связь</h5>
                <ul><li>+7 (495) 123-45-67</li><li>Москва, ул. Портовая, 12</li><li><a href="#">Telegram</a> · <a href="#">VK</a> · <a href="#">YouTube</a></li></ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© <?= date('Y') ?> Новостной портал. Все права защищены.</span>
            <span>Вариант 11 — HMVC · News · Categories · Comments · Users</span>
        </div>
    </div>
</footer>
<script>
document.querySelectorAll('[data-slider]').forEach(function (root) {
    var slides = root.querySelectorAll('.hero-slide'), arts = root.querySelectorAll('.hero-art .cover'), btns = root.querySelectorAll('.hero-nav button'), cur = 0, timer;
    function show(i) { cur = i; [slides, arts, btns].forEach(function (list) { list.forEach(function (el, k) { el.classList.toggle('active', k === i); }); }); }
    function auto() { clearInterval(timer); timer = setInterval(function () { show((cur + 1) % slides.length); }, 7000); }
    btns.forEach(function (b, i) { b.addEventListener('click', function () { show(i); auto(); }); });
    if (slides.length > 1) auto();
});
</script>
</body>
</html>
    <?php
}

// ============================================================================
// POST ACTIONS
// ============================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        switch ($_POST['action'] ?? '') {
            case 'login':
                $ok = Registry::get('users')->login($_POST['login'] ?? '', $_POST['password'] ?? '');
                flash($ok ? 'Вы вошли' : 'Неверный логин или пароль');
                redirect('?page=home');
            case 'create_news':
                $id = Registry::get('news')->create([
                    'title'=>trim($_POST['title'] ?? ''),
                    'short'=>trim($_POST['short'] ?? ''),
                    'body'=>trim($_POST['body'] ?? ''),
                    'image'=>trim($_POST['image'] ?? ''),
                    'category_id'=>(int)($_POST['category_id'] ?? 0),
                ]);
                flash('Новость создана (черновик)');
                redirect("?page=view&id=$id");
            case 'update_news':
                $id = (int)($_POST['id'] ?? 0);
                Registry::get('news')->update($id, [
                    'title'=>trim($_POST['title'] ?? ''),
                    'short'=>trim($_POST['short'] ?? ''),
                    'body'=>trim($_POST['body'] ?? ''),
                    'image'=>trim($_POST['image'] ?? ''),
                    'category_id'=>(int)($_POST['category_id'] ?? 0),
                ]);
                flash('Новость обновлена');
                redirect("?page=view&id=$id");
            case 'publish_news':
                $id = (int)($_POST['id'] ?? 0);
                Registry::get('news')->publish($id);
                flash('Новость опубликована');
                redirect("?page=view&id=$id");
            case 'delete_news':
                $id = (int)($_POST['id'] ?? 0);
                Registry::get('news')->delete($id);
                flash('Новость удалена');
                redirect('?page=home');
            case 'add_comment':
                $nid = (int)($_POST['news_id'] ?? 0);
                $u = Auth::user();
                if (!$u) { flash('Войдите'); redirect("?page=view&id=$nid"); }
                $t = trim($_POST['text'] ?? '');
                if ($t !== '') Registry::get('comments')->add($nid, $u['id'], $t);
                redirect("?page=view&id=$nid");
            case 'delete_comment':
                Registry::get('comments')->delete((int)($_POST['id'] ?? 0));
                flash('Комментарий удалён');
                redirect("?page=view&id=" . (int)($_POST['news_id'] ?? 0));
            case 'register':
                if (Auth::user()) redirect('?page=home');
                if (($_POST['password'] ?? '') !== ($_POST['password2'] ?? '')) throw new RuntimeException('Пароли не совпадают');
                $uid = Registry::get('users')->register(trim($_POST['name'] ?? ''), trim($_POST['login'] ?? ''), $_POST['password'] ?? '');
                Auth::login($uid);
                flash('Добро пожаловать! Аккаунт создан');
                redirect('?page=home');
            case 'create_user':
                Registry::get('users')->create(trim($_POST['name'] ?? ''), trim($_POST['login'] ?? ''), $_POST['password'] ?? '', $_POST['role'] ?? 'user');
                flash('Пользователь создан');
                redirect('?page=users');
            case 'set_role':
                Registry::get('users')->setRole((int)($_POST['id'] ?? 0), $_POST['role'] ?? '');
                flash('Роль изменена');
                redirect('?page=users');
            case 'delete_user':
                Registry::get('users')->delete((int)($_POST['id'] ?? 0));
                flash('Пользователь удалён');
                redirect('?page=users');
            case 'create_category':
                $name = trim($_POST['name'] ?? '');
                if ($name !== '') Registry::get('categories')->create($name);
                flash('Категория создана');
                redirect('?page=categories');
        }
    } catch (Throwable $ex) {
        flash('Ошибка: ' . $ex->getMessage());
        $back = $_POST['back'] ?? '';
        redirect(in_array($back, ['?page=register', '?page=users'], true) ? $back : '?page=home');
    }
}

// ============================================================================
// ROUTING
// ============================================================================
$page = $_GET['page'] ?? 'home';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

switch ($page) {
    case 'logout':
        Auth::logout();
        redirect('?page=home');

    case 'login':
        ob_start(); ?>
        <h1>Вход</h1>
        <p style="color:var(--muted);margin-bottom:8px">Демо: <b>admin/admin</b>, <b>editor/editor</b>, <b>user/user</b></p>
        <p style="color:var(--muted);margin-bottom:20px">Нет аккаунта? <a href="?page=register" style="text-decoration:underline">Зарегистрироваться</a></p>
        <form method="post" class="box">
            <input type="hidden" name="action" value="login">
            <label>Логин</label><input type="text" name="login" required>
            <label>Пароль</label><input type="password" name="password" required>
            <button type="submit">Войти</button>
        </form>
        <?php render_page('Вход', ob_get_clean()); break;

    case 'register':
        if (Auth::user()) redirect('?page=home');
        ob_start(); ?>
        <h1>Регистрация</h1>
        <p style="color:var(--muted);margin-bottom:20px">Уже есть аккаунт? <a href="?page=login" style="text-decoration:underline">Войти</a></p>
        <form method="post" class="box">
            <input type="hidden" name="action" value="register">
            <input type="hidden" name="back" value="?page=register">
            <label>Имя</label><input type="text" name="name" required maxlength="50">
            <label>Логин (латиница, цифры, _)</label><input type="text" name="login" required pattern="[A-Za-z0-9_]{3,20}">
            <label>Пароль (от 6 символов)</label><input type="password" name="password" required minlength="6">
            <label>Повторите пароль</label><input type="password" name="password2" required minlength="6">
            <button type="submit">Создать аккаунт</button>
        </form>
        <?php render_page('Регистрация', ob_get_clean()); break;

    case 'users':
        if (!Auth::isAdmin()) { flash('Нет прав'); redirect('?page=home'); }
        $me = Auth::user();
        ob_start(); ?>
        <h1>Пользователи</h1>
        <div class="table-wrap">
        <table class="users-table">
            <thead><tr><th>Имя</th><th>Логин</th><th>Роль</th><th>Создан</th><th></th></tr></thead>
            <tbody>
            <?php foreach (Registry::get('users')->all() as $u): $self = $u['id'] === $me['id']; ?>
                <tr>
                    <td><b><?= e($u['name']) ?></b><?= $self ? ' <small style="color:var(--muted)">(вы)</small>' : '' ?></td>
                    <td><?= e($u['login']) ?></td>
                    <td>
                        <?php if ($self): ?>
                            <span class="role-pill <?= e($u['role']) ?>"><?= e(role_label($u['role'])) ?></span>
                        <?php else: ?>
                            <form method="post">
                                <input type="hidden" name="action" value="set_role"><input type="hidden" name="back" value="?page=users"><input type="hidden" name="id" value="<?= $u['id'] ?>">
                                <select name="role">
                                    <?php foreach (UsersController::ROLES as $r): ?><option value="<?= $r ?>" <?= $u['role'] === $r ? 'selected' : '' ?>><?= e(role_label($r)) ?></option><?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn secondary small">Сохранить</button>
                            </form>
                        <?php endif; ?>
                    </td>
                    <td><?= e($u['created_at'] ?? '—') ?></td>
                    <td>
                        <?php if (!$self): ?>
                            <form method="post" onsubmit="return confirm('Удалить пользователя?')">
                                <input type="hidden" name="action" value="delete_user"><input type="hidden" name="back" value="?page=users"><input type="hidden" name="id" value="<?= $u['id'] ?>">
                                <button type="submit" class="btn danger small">Удалить</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <h2>Добавить пользователя</h2>
        <form method="post" class="box">
            <input type="hidden" name="action" value="create_user"><input type="hidden" name="back" value="?page=users">
            <label>Имя</label><input type="text" name="name" required maxlength="50">
            <label>Логин</label><input type="text" name="login" required pattern="[A-Za-z0-9_]{3,20}">
            <label>Пароль (от 6 символов)</label><input type="password" name="password" required minlength="6">
            <label>Роль</label>
            <select name="role"><?php foreach (UsersController::ROLES as $r): ?><option value="<?= $r ?>" <?= $r === 'user' ? 'selected' : '' ?>><?= e(role_label($r)) ?></option><?php endforeach; ?></select>
            <button type="submit">Создать</button>
        </form>
        <?php render_page('Пользователи', ob_get_clean()); break;

    case 'categories':
        ob_start(); ?>
        <h1>Категории</h1>
        <?php if (Auth::canEdit()): ?>
            <form method="post" class="box">
                <input type="hidden" name="action" value="create_category">
                <label>Новая категория</label>
                <input type="text" name="name" required placeholder="Например, Культура">
                <button type="submit">Создать</button>
            </form>
        <?php endif; ?>
        <div class="tiles">
            <?php foreach (Registry::get('categories')->all() as $c):
                $byCat = Registry::get('news')->byCategory($c['id']); $first = $byCat[0] ?? null; ?>
                <a class="tile" href="?page=category&id=<?= $c['id'] ?>">
                    <?= $first ? news_cover($first, 'tile-img') : "<div class='cover tile-img' style='--c:#888'><span class='cover-emoji'>" . cat_meta($c['id'])[0] . "</span></div>" ?>
                    <div class="t-name"><?= e($c['name']) ?> <span><?= CategoryModel::countNewsIn($c['id']) ?></span></div>
                </a>
            <?php endforeach; ?>
        </div>
        <?php render_page('Категории', ob_get_clean()); break;

    case 'category':
        $cat = Registry::get('categories')->find($id);
        ob_start();
        if (!$cat) { echo "<div class='empty'>Категория не найдена</div>"; }
        else {
            echo "<h1>" . e($cat['name']) . "</h1>";
            $items = Registry::get('news')->byCategory($id);
            if (empty($items)) echo "<div class='empty'>Новостей пока нет</div>";
            else {
                echo "<div class='news-grid'>";
                foreach ($items as $n) echo news_card($n);
                echo "</div>";
            }
        }
        render_page($cat['name'] ?? 'Категория', ob_get_clean()); break;

    case 'view':
        $news = Registry::get('news')->find($id);
        if (!$news) { render_page('Не найдено', "<div class='empty'>Новость не найдена</div>"); break; }
        $comments = Registry::get('comments')->forNews($id);
        $users = Registry::get('users')->all();
        $cat = Registry::get('categories')->find($news['category_id']);
        $badge = $news['status']==='published' ? "<span class='badge pub'>Опубликовано</span>" : "<span class='badge draft'>Черновик</span>";
        ob_start(); ?>
        <h1><?= e($news['title']) ?> <?= $badge ?></h1>
        <p class="meta">
            Автор: <b><?= e($news['author']) ?></b> · Категория: <a href="?page=category&id=<?= $news['category_id'] ?>"><?= e($cat['name'] ?? '—') ?></a>
            <?php if ($news['published_at']): ?> · Опубликовано: <?= e($news['published_at']) ?><?php endif; ?>
        </p>
        <?= news_cover($news, 'article-hero') ?>
        <div class="content-body">
            <p class="lead"><?= e($news['short']) ?></p>
            <?php foreach (preg_split('/\R\s*\R/', $news['body']) as $para): if (trim($para) === '') continue; ?>
                <p><?= nl2br(e(trim($para))) ?></p>
            <?php endforeach; ?>
        </div>
        <div class="actions">
            <?php if (Auth::canEdit()): ?>
                <a class="btn secondary" href="?page=edit&id=<?= $news['id'] ?>">Редактировать</a>
                <?php if ($news['status'] !== 'published'): ?>
                    <form method="post"><input type="hidden" name="action" value="publish_news"><input type="hidden" name="id" value="<?= $news['id'] ?>"><button type="submit">Опубликовать</button></form>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (Auth::canDelete()): ?>
                <form method="post" onsubmit="return confirm('Удалить новость?')"><input type="hidden" name="action" value="delete_news"><input type="hidden" name="id" value="<?= $news['id'] ?>"><button type="submit" class="btn danger">Удалить</button></form>
            <?php endif; ?>
        </div>
        <h2>Комментарии (<?= count($comments) ?>)</h2>
        <div class="comments">
            <?php if (empty($comments)): ?>
                <div class="empty">Комментариев пока нет</div>
            <?php else: foreach ($comments as $c): ?>
                <div class="comment">
                    <strong><?= e($users[$c['user_id']]['name'] ?? 'Аноним') ?></strong>
                    <span class="date"><?= e($c['created_at']) ?></span>
                    <p><?= e($c['text']) ?></p>
                    <?php if (Auth::canEdit()): ?>
                        <form method="post"><input type="hidden" name="action" value="delete_comment"><input type="hidden" name="id" value="<?= $c['id'] ?>"><input type="hidden" name="news_id" value="<?= $news['id'] ?>"><button type="submit" class="btn danger small">Удалить</button></form>
                    <?php endif; ?>
                </div>
            <?php endforeach; endif; ?>
        </div>
        <?php if (Auth::user()): ?>
            <form method="post" class="box" style="margin-top:20px">
                <input type="hidden" name="action" value="add_comment">
                <input type="hidden" name="news_id" value="<?= $news['id'] ?>">
                <label>Ваш комментарий</label><textarea name="text" required></textarea>
                <button type="submit">Отправить</button>
            </form>
        <?php else: ?>
            <p style="margin-top:20px;color:#64748b">Чтобы комментировать, <a href="?page=login">войдите</a>.</p>
        <?php endif; ?>
        <?php
        $related = array_values(array_filter(Registry::get('news')->published(), fn($r) => $r['id'] !== $news['id']));
        usort($related, fn($a, $b) => ($b['category_id'] === $news['category_id']) <=> ($a['category_id'] === $news['category_id']) ?: strcmp($b['published_at'] ?? '', $a['published_at'] ?? ''));
        if ($related): ?>
            <h2 class="related-title section-title">Читайте также</h2>
            <div class="news-grid"><?php foreach (array_slice($related, 0, 3) as $r) echo news_card($r); ?></div>
        <?php endif; ?>
        <?php render_page($news['title'], ob_get_clean()); break;

    case 'create':
        if (!Auth::canEdit()) { flash('Нет прав'); redirect('?page=home'); }
        ob_start(); ?>
        <h1>Создать новость</h1>
        <form method="post" class="box">
            <input type="hidden" name="action" value="create_news">
            <label>Заголовок</label><input type="text" name="title" required>
            <label>Краткое описание</label><input type="text" name="short" required>
            <label>Ссылка на картинку (URL)</label><input type="text" name="image" placeholder="https://...">
            <label>Основной текст</label><textarea name="body" required></textarea>
            <label>Категория</label>
            <select name="category_id" required>
                <?php foreach (Registry::get('categories')->all() as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Создать</button>
        </form>
        <?php render_page('Создать', ob_get_clean()); break;

    case 'edit':
        if (!Auth::canEdit()) { flash('Нет прав'); redirect('?page=home'); }
        $news = Registry::get('news')->find($id);
        if (!$news) { flash('Не найдено'); redirect('?page=home'); }
        ob_start(); ?>
        <h1>Редактировать</h1>
        <form method="post" class="box">
            <input type="hidden" name="action" value="update_news">
            <input type="hidden" name="id" value="<?= $news['id'] ?>">
            <label>Заголовок</label><input type="text" name="title" value="<?= e($news['title']) ?>" required>
            <label>Краткое описание</label><input type="text" name="short" value="<?= e($news['short']) ?>" required>
            <label>Ссылка на картинку (URL)</label><input type="text" name="image" value="<?= e($news['image'] ?? '') ?>" placeholder="https://...">
            <label>Основной текст</label><textarea name="body" required><?= e($news['body']) ?></textarea>
            <label>Категория</label>
            <select name="category_id" required>
                <?php foreach (Registry::get('categories')->all() as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id']===$news['category_id']?'selected':'' ?>><?= e($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Сохранить</button>
            <a class="btn secondary" href="?page=view&id=<?= $news['id'] ?>">Отмена</a>
        </form>
        <?php render_page('Редактировать', ob_get_clean()); break;

    case 'home':
    default:
        $all = Registry::get('news')->published();
        usort($all, fn($a,$b) => strcmp($b['published_at'] ?? '', $a['published_at'] ?? ''));
        $slides = array_slice($all, 0, 5);
        $cats = Registry::get('categories')->all();
        $roman = ['I','II','III','IV','V'];
        ob_start(); ?>

        <?php if ($slides): ?>
        <section class="hero" data-slider>
            <div>
                <div class="hero-tags">
                    <?php foreach ($cats as $c): ?><span class="tag"><?= e($c['name']) ?></span><?php endforeach; ?>
                </div>
                <div class="hero-slides">
                    <?php foreach ($slides as $i => $n):
                        $cn = Registry::get('categories')->find($n['category_id']); ?>
                        <article class="hero-slide <?= $i === 0 ? 'active' : '' ?>">
                            <span class="eyebrow"><?= e($cn['name'] ?? '') ?> · <?= date('d.m.Y', strtotime($n['published_at'])) ?></span>
                            <h1><?= e($n['title']) ?></h1>
                            <p><?= e($n['short']) ?></p>
                            <a href="?page=view&id=<?= $n['id'] ?>" class="btn">Читать полностью</a>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="hero-nav">
                    <?php foreach ($slides as $i => $n): ?><button type="button" class="<?= $i === 0 ? 'active' : '' ?>" aria-label="Новость <?= $i + 1 ?>"><?= $roman[$i] ?></button><?php endforeach; ?>
                </div>
            </div>
            <div class="hero-art">
                <?php foreach ($slides as $i => $n): ?><?= news_cover($n, 'hero-img' . ($i === 0 ? ' active' : '')) ?><?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <div class="sec-head">
            <h2>Рубрики</h2>
            <p>Выберите тему — наука, технологии, образование или спорт.</p>
        </div>
        <div class="tiles">
            <?php foreach ($cats as $c):
                $first = null;
                foreach ($all as $n) if ($n['category_id'] === $c['id']) { $first = $n; break; } ?>
                <a class="tile" href="?page=category&id=<?= $c['id'] ?>">
                    <?= $first ? news_cover($first, 'tile-img') : "<div class='cover tile-img' style='--c:#888'><span class='cover-emoji'>" . cat_meta($c['id'])[0] . "</span></div>" ?>
                    <div class="t-name"><?= e($c['name']) ?> <span><?= CategoryModel::countNewsIn($c['id']) ?></span></div>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="sec-head">
            <h2>Лента новостей</h2>
            <p>Свежие материалы редакции — от новых видов животных до выхода новых версий языков программирования.</p>
        </div>
        <?php if (empty($all)): ?>
            <div class="empty">Новостей пока нет</div>
        <?php else: ?>
            <div class="news-grid"><?php foreach ($all as $n) echo news_card($n); ?></div>
        <?php endif; ?>

        <section class="how">
            <div>
                <h2>Как мы работаем</h2>
                <p class="lead">Короткие материалы по делу: что произошло, почему это важно и где прочитать подробнее.</p>
            </div>
            <div>
                <details class="acc" open><summary><b>I</b> Проверяем источники</summary><p>Опираемся на первоисточники: пресс-релизы институтов, журналы и официальные блоги.</p></details>
                <details class="acc"><summary><b>II</b> Пишем коротко</summary><p>Заголовок, краткое описание и основной текст — без воды и лишних подробностей.</p></details>
                <details class="acc"><summary><b>III</b> Обновляем регулярно</summary><p>Редакторы публикуют черновики после проверки, а администратор следит за порядком.</p></details>
                <details class="acc"><summary><b>IV</b> Обсуждаем вместе</summary><p>Зарегистрированные читатели оставляют комментарии под каждой новостью.</p></details>
            </div>
        </section>

        <section class="newsletter">
            <div>
                <h2>Получать письма</h2>
                <p>Раз в неделю присылаем главные новости науки и технологий.</p>
            </div>
            <form onsubmit="event.preventDefault(); alert('Спасибо за подписку!');">
                <input type="email" placeholder="Ваш email" required><button type="submit">Подписаться</button>
            </form>
        </section>
        <?php render_page('Главная', ob_get_clean());
}