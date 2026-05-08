const CATEGORY_LINKS = [
    { slug: "phones", label: "Phones", href: "phones.html" },
    { slug: "wearables", label: "Wearables", href: "wearables.html" },
    { slug: "computers", label: "Computers", href: "computers.html" },
    { slug: "tablets", label: "Tablets", href: "tablets.html" },
    { slug: "visions", label: "Vision", href: "visions.html" },
    { slug: "audio", label: "Audio", href: "audio.html" },
    { slug: "wholehome", label: "Whole Home", href: "wholehome.html" },
    { slug: "routers", label: "Routers", href: "routers.html" },
    { slug: "dragonos", label: "DragonOS 6", href: "dragonos.html" }
];

const UTILITY_LINKS = [
    { slug: "support", label: "Support", href: "support.html" },
    { slug: "retail", label: "Retail", href: "retail.html" },
    { slug: "business", label: "Business", href: "business.html" },
    { slug: "store", label: "DragonMall", href: "store.html" }
];

const DETAIL_PATH = "../../DetailIntroduction/DetailIntroductinoDragonGodXProMax.html";
const SELL_PATH = "../../SellPage(addcar)/SellPage.html";
const LOGIN_URL = "../../Login&Registration/Login.html?source=channel-pages&redirect=sell";

function buildCatalogUrl(path, defaultParams, overrides = {}) {
    return `${path}?${new URLSearchParams({
        ...defaultParams,
        ...overrides
    }).toString()}`;
}

function detailUrl(overrides = {}) {
    return buildCatalogUrl(DETAIL_PATH, {
        product: "aether-fold-one",
        section: "story",
        scene: "phones-channel"
    }, overrides);
}

function sellUrl(overrides = {}) {
    return buildCatalogUrl(SELL_PATH, {
        sku: "aether-fold-one-512",
        campaign: "channel-pages",
        source: "channel-pages"
    }, overrides);
}

const PAGE_DATA = {
    phones: {
        documentTitle: "DragonGod Phones",
        pageLabel: "DragonGod Phones",
        eyebrow: "DragonGod Phont",
        heroTitle: "Aether phones for every scale of use.",
        heroSubtitle: "Foldables, portrait flagships, and lightweight daily devices in one family.",
        heroDescription: "This page corresponds to the top-row Phones channel and works like a family landing page instead of a single product detail page.",
        badgeLabel: "Featured model",
        badgeValue: "Aether Fold One",
        heroKind: "phones",
        heroActions: [
            { label: "Open product homepage", href: "../index.html", style: "ghost" },
            { label: "View specs", href: detailUrl({ section: "specs", scene: "phones-channel" }), style: "text" },
            { label: "Buy now", href: sellUrl({ campaign: "phones-channel", source: "phones-page" }), style: "solid" }
        ],
        headerActions: [
            { label: "Product home", href: "../index.html" },
            { label: "Buy now", href: sellUrl({ campaign: "phones-subbar", source: "phones-page" }) }
        ],
        metrics: [
            { value: "7.8-inch", label: "Foldable inner display" },
            { value: "StarSight", label: "Original imaging system" },
            { value: "66 W", label: "Wired fast charge" },
            { value: "5300 mAh", label: "Flagship battery" }
        ],
        sectionTitle: "Phones channel highlights",
        sectionIntro: "The channel sits above any one model and introduces the full device family, the same way the Huawei phone channel behaves above its product details.",
        highlights: [
            { title: "Foldable flagship", text: "Aether Fold One remains the visual and functional anchor of the entire site." },
            { title: "Portrait imaging", text: "StarSight naming keeps portraits, night scenes, and zoom stories consistent across the range." },
            { title: "Lightweight line", text: "Aether Air keeps space open for a thinner everyday device and future team expansion." },
            { title: "Direct handoff", text: "The buy and detail flows continue to the existing pages without changing those core files." }
        ],
        storyTitle: "Lineup structure",
        storyIntro: "This page behaves as a real category entrance with product-family logic, not a repeated collection of identical product cards.",
        stories: [
            { kicker: "Foldable hero", title: "Aether Fold One", text: "The current homepage flagship carries the strongest identity and remains the center of the brand story." },
            { kicker: "Imaging hero", title: "Aether Vision Pro", text: "A straight-bar imaging flagship keeps the family believable and expands the ecosystem beyond one foldable." },
            { kicker: "Light flagship", title: "Aether Air", text: "A thinner, lighter daily phone adds range to the portfolio so the channel feels like a real site entrance." }
        ],
        related: ["wearables", "store", "support"]
    },
    wearables: {
        documentTitle: "DragonGod Wearables",
        pageLabel: "DragonGod Wearables",
        eyebrow: "DragonGod Phont",
        heroTitle: "Wearables that stay connected to the phone story.",
        heroSubtitle: "Watches, bands, and smart rings built to orbit the Aether phone family.",
        heroDescription: "This page mirrors the Huawei-style category pages by acting as a separate landing page for a product family rather than a single item.",
        badgeLabel: "Hero wearable",
        badgeValue: "Halo Watch X",
        heroKind: "wearables",
        heroActions: [
            { label: "Open phones channel", href: "phones.html", style: "ghost" },
            { label: "Service support", href: LOGIN_URL, style: "text" },
            { label: "DragonMall entry", href: "store.html", style: "solid" }
        ],
        headerActions: [
            { label: "Support", href: "support.html" },
            { label: "Store", href: "store.html" }
        ],
        metrics: [
            { value: "14 days", label: "Typical battery life" },
            { value: "FlowSync", label: "Phone-watch continuity" },
            { value: "5 ATM", label: "Water resistance" },
            { value: "3 devices", label: "Family pairing paths" }
        ],
        sectionTitle: "Wearables channel highlights",
        sectionIntro: "The page is built as a real companion category that reinforces the phone channel instead of copying the buy flow or detail flow.",
        highlights: [
            { title: "Flagship watch", text: "Halo Watch X carries the premium identity for fitness, health, and design storytelling." },
            { title: "Light band", text: "Motion Band Lite covers entry-level tracking and broadens the channel structure." },
            { title: "Smart ring", text: "Pulse Ring adds a new wearable form factor and makes the category feel contemporary." },
            { title: "Phone continuity", text: "Everything here remains linked back to phones, support, and the store entry page." }
        ],
        storyTitle: "Wearable lineup",
        storyIntro: "Huawei uses channel pages to introduce a family view first. This page follows that logic with a cleaner English presentation.",
        stories: [
            { kicker: "Daily health", title: "Halo Watch X", text: "Large display, strong battery life, and tighter continuity with Aether phones." },
            { kicker: "Fitness light", title: "Motion Band Lite", text: "A lighter entry point for motion tracking and notifications." },
            { kicker: "Minimal form", title: "Pulse Ring", text: "A ring-based device keeps the channel varied and future-ready." }
        ],
        related: ["phones", "audio", "support"]
    },
    computers: {
        documentTitle: "DragonGod Computers",
        pageLabel: "DragonGod Computers",
        eyebrow: "DragonGod Phont",
        heroTitle: "Computers that extend the mobile workspace.",
        heroSubtitle: "Thin notebooks, creator models, and desktop workflows aligned with the Aether ecosystem.",
        heroDescription: "The computer channel works as its own category entrance, mirroring how the Huawei site separates brand families before you enter a single product page.",
        badgeLabel: "Flagship notebook",
        badgeValue: "AtlasBook Pro 14",
        heroKind: "computers",
        heroActions: [
            { label: "Open DragonOS page", href: "dragonos.html", style: "ghost" },
            { label: "View specs", href: detailUrl({ section: "workflow", scene: "computers-channel" }), style: "text" },
            { label: "Business page", href: "business.html", style: "solid" }
        ],
        headerActions: [
            { label: "DragonOS 6", href: "dragonos.html" },
            { label: "Business", href: "business.html" }
        ],
        metrics: [
            { value: "14-inch", label: "Creator notebook size" },
            { value: "120 Hz", label: "High refresh display" },
            { value: "32 GB", label: "Performance memory tier" },
            { value: "MultiSync", label: "Phone-laptop continuity" }
        ],
        sectionTitle: "Computers channel highlights",
        sectionIntro: "The layout keeps the channel separate from product detail pages while still linking back into the homepage and existing detail and purchase flows.",
        highlights: [
            { title: "Creator notebook", text: "AtlasBook Pro is positioned as the main premium laptop in the ecosystem." },
            { title: "Thin and light", text: "AtlasBook Air covers portability and broadens the category structure." },
            { title: "Desktop workstation", text: "AtlasStation keeps room for a performance desktop narrative." },
            { title: "Cross-device flow", text: "Every channel page keeps shared navigation so the site behaves like one connected web property." }
        ],
        storyTitle: "Workflow stories",
        storyIntro: "This section maps the computer family to real use cases instead of stopping at a single hero product.",
        stories: [
            { kicker: "Creator", title: "AtlasBook Pro 14", text: "Color work, review sessions, and presentation workflows in one portable machine." },
            { kicker: "Portable", title: "AtlasBook Air 13", text: "A lighter model for everyday mobility across campus and office scenes." },
            { kicker: "Performance", title: "AtlasStation", text: "A fixed desktop tier keeps the category believable for larger professional work." }
        ],
        related: ["tablets", "dragonos", "business"]
    },
    tablets: {
        documentTitle: "DragonGod Tablets",
        pageLabel: "DragonGod Tablets",
        eyebrow: "DragonGod Phont",
        heroTitle: "Tablets built for sketching, note-taking, and second-screen work.",
        heroSubtitle: "A tablet family positioned between mobile creativity and desktop continuity.",
        heroDescription: "The tablet channel behaves as a true category landing page and creates room for future products instead of pretending to be a detail page.",
        badgeLabel: "Creator tablet",
        badgeValue: "NovaPad Pro",
        heroKind: "tablets",
        heroActions: [
            { label: "Open wearables", href: "wearables.html", style: "ghost" },
            { label: "Product details", href: detailUrl({ section: "canvas", scene: "tablets-channel" }), style: "text" },
            { label: "Store page", href: "store.html", style: "solid" }
        ],
        headerActions: [
            { label: "Support", href: "support.html" },
            { label: "Store", href: "store.html" }
        ],
        metrics: [
            { value: "12.4-inch", label: "Canvas display" },
            { value: "144 Hz", label: "High response panel" },
            { value: "Comet Pen", label: "Stylus family" },
            { value: "Desk Mode", label: "Extended workflow" }
        ],
        sectionTitle: "Tablet channel highlights",
        sectionIntro: "The page emphasizes creative workflow, accessory support, and cross-device continuity rather than buy-page repetition.",
        highlights: [
            { title: "Creator first", text: "NovaPad Pro anchors the channel for drawing, note-taking, and layout review." },
            { title: "Student tier", text: "NovaPad Air keeps the category more complete and practical." },
            { title: "Mini format", text: "InkSlate Mini extends the lineup into a more compact reading and control device." },
            { title: "Accessory logic", text: "Stylus, case, and desk mode links make the page feel like a real category entrance." }
        ],
        storyTitle: "Tablet family",
        storyIntro: "This is structured more like an official category gateway and less like a one-product promotion page.",
        stories: [
            { kicker: "Flagship", title: "NovaPad Pro", text: "Large canvas, stylus precision, and strong continuity with the phone and notebook ecosystem." },
            { kicker: "Everyday", title: "NovaPad Air", text: "A lighter tablet for schoolwork, reading, and call continuity." },
            { kicker: "Compact", title: "InkSlate Mini", text: "A smaller device for reading, note capture, and quick control tasks." }
        ],
        related: ["computers", "store", "support"]
    },
    visions: {
        documentTitle: "DragonGod Vision",
        pageLabel: "DragonGod Vision",
        eyebrow: "DragonGod Phont",
        heroTitle: "Large-screen products that extend the home experience.",
        heroSubtitle: "Connected displays, smart panels, and cinematic living room hardware.",
        heroDescription: "This channel replaces section jumps with a real standalone landing page, similar to the Huawei top-row category pages.",
        badgeLabel: "Hero display",
        badgeValue: "LumiView X 75",
        heroKind: "visions",
        heroActions: [
            { label: "Open whole home", href: "wholehome.html", style: "ghost" },
            { label: "Support page", href: "support.html", style: "text" },
            { label: "Retail page", href: "retail.html", style: "solid" }
        ],
        headerActions: [
            { label: "Retail", href: "retail.html" },
            { label: "Support", href: "support.html" }
        ],
        metrics: [
            { value: "75-inch", label: "Flagship display size" },
            { value: "Mini LED", label: "Panel technology" },
            { value: "4K 144 Hz", label: "Cinematic refresh tier" },
            { value: "DragonOS Hub", label: "Whole-home control layer" }
        ],
        sectionTitle: "Vision channel highlights",
        sectionIntro: "The page acts as a high-level visual and product-family entry so the site behaves like a multi-category brand website.",
        highlights: [
            { title: "Home cinema", text: "LumiView X leads the premium entertainment story with large-format visuals." },
            { title: "Smart panel", text: "Vision Hub covers kitchen, hallway, and control-center scenarios." },
            { title: "Shared ecosystem", text: "The channel connects cleanly to whole-home products, support, and retail pages." },
            { title: "Retail-ready", text: "Large-screen products are also pushed toward the retail page, matching real showroom behavior." }
        ],
        storyTitle: "Home display range",
        storyIntro: "A real channel page should reveal the structure of the category, not just one marketing headline.",
        stories: [
            { kicker: "Cinema", title: "LumiView X 75", text: "The main cinematic screen for premium living room use." },
            { kicker: "Family", title: "HomeCanvas 65", text: "A more accessible family screen for everyday entertainment." },
            { kicker: "Control", title: "Vision Hub", text: "A wall-oriented display for quick control, calls, and household views." }
        ],
        related: ["wholehome", "retail", "support"]
    },
    audio: {
        documentTitle: "DragonGod Audio",
        pageLabel: "DragonGod Audio",
        eyebrow: "DragonGod Phont",
        heroTitle: "Audio products that keep the ecosystem sounding consistent.",
        heroSubtitle: "Earbuds, speakers, and studio accessories for calls, music, and immersive playback.",
        heroDescription: "The audio page works as its own category entrance and links cleanly back to phones, wearables, and the store.",
        badgeLabel: "Hero audio product",
        badgeValue: "EchoBuds Pro",
        heroKind: "audio",
        heroActions: [
            { label: "Open wearables", href: "wearables.html", style: "ghost" },
            { label: "Support page", href: "support.html", style: "text" },
            { label: "Store page", href: "store.html", style: "solid" }
        ],
        headerActions: [
            { label: "Support", href: "support.html" },
            { label: "DragonMall", href: "store.html" }
        ],
        metrics: [
            { value: "48 dB", label: "Noise reduction tier" },
            { value: "Spatial Audio", label: "Immersive playback" },
            { value: "36 hrs", label: "Case battery life" },
            { value: "MultiPair", label: "Device switching" }
        ],
        sectionTitle: "Audio channel highlights",
        sectionIntro: "The channel provides a real family structure for audio products instead of burying them inside the homepage.",
        highlights: [
            { title: "Premium earbuds", text: "EchoBuds Pro anchors the portable listening story for the brand." },
            { title: "Home speaker", text: "Resonance Speaker extends the range into room-scale playback." },
            { title: "Creator audio", text: "StudioPods provide a more work-focused listening tier." },
            { title: "Shared controls", text: "Store and support routes stay visible so the page feels fully connected." }
        ],
        storyTitle: "Audio family",
        storyIntro: "This structure mirrors the category logic of the Huawei site while staying original in naming and copy.",
        stories: [
            { kicker: "Portable", title: "EchoBuds Pro", text: "Noise reduction, call clarity, and fast pairing with DragonGod phones." },
            { kicker: "Home", title: "Resonance Speaker", text: "A stationary speaker for living room music and voice control." },
            { kicker: "Focus", title: "StudioPods", text: "A more concentrated audio tier for editing, travel, and office work." }
        ],
        related: ["phones", "store", "support"]
    },
    wholehome: {
        documentTitle: "DragonGod Whole Home",
        pageLabel: "DragonGod Whole Home",
        eyebrow: "DragonGod Phont",
        heroTitle: "Whole-home products arranged as one connected environment.",
        heroSubtitle: "Lighting, sensors, hubs, and displays built into a single control layer.",
        heroDescription: "This page functions as the top-row whole-home channel instead of a product detail page, giving the site a real multi-category structure.",
        badgeLabel: "Core control device",
        badgeValue: "FlowHub Max",
        heroKind: "wholehome",
        heroActions: [
            { label: "Open vision page", href: "visions.html", style: "ghost" },
            { label: "Retail page", href: "retail.html", style: "text" },
            { label: "Support page", href: "support.html", style: "solid" }
        ],
        headerActions: [
            { label: "Retail", href: "retail.html" },
            { label: "Support", href: "support.html" }
        ],
        metrics: [
            { value: "1 app", label: "Unified control layer" },
            { value: "200+", label: "Scene combinations" },
            { value: "MeshLink", label: "Room-to-room control" },
            { value: "Low power", label: "Always-on sensors" }
        ],
        sectionTitle: "Whole-home channel highlights",
        sectionIntro: "The official site uses category pages to stage a family and then link deeper. This page follows that same structural logic.",
        highlights: [
            { title: "Central hub", text: "FlowHub Max acts as the control heart of the household device network." },
            { title: "Lighting scenes", text: "LightBridge products expand the channel into ambience and automation." },
            { title: "Environmental sensing", text: "AirSense modules make the family feel practical and complete." },
            { title: "Retail pathway", text: "Physical stores stay part of the flow for larger household purchases." }
        ],
        storyTitle: "System layout",
        storyIntro: "A category page for whole-home products should explain how the pieces fit together, not just advertise one SKU.",
        stories: [
            { kicker: "Control", title: "FlowHub Max", text: "The central coordination point for device scenes and family automation." },
            { kicker: "Environment", title: "AirSense Node", text: "A compact sensor module for air quality, presence, and ambient logic." },
            { kicker: "Lighting", title: "LightBridge Rail", text: "A modular lighting path for room-wide scene control." }
        ],
        related: ["visions", "routers", "support"]
    },
    routers: {
        documentTitle: "DragonGod Routers",
        pageLabel: "DragonGod Routers",
        eyebrow: "DragonGod Phont",
        heroTitle: "Routers and mesh products for strong home coverage.",
        heroSubtitle: "High-speed signal, whole-home coverage, and cleaner setup for the wider ecosystem.",
        heroDescription: "This page gives the top-row Routers item a real destination so the navigation behaves like a complete brand site.",
        badgeLabel: "Flagship router",
        badgeValue: "StormLink X7",
        heroKind: "routers",
        heroActions: [
            { label: "Open whole home", href: "wholehome.html", style: "ghost" },
            { label: "Support page", href: "support.html", style: "text" },
            { label: "DragonMall", href: "store.html", style: "solid" }
        ],
        headerActions: [
            { label: "Support", href: "support.html" },
            { label: "Store", href: "store.html" }
        ],
        metrics: [
            { value: "Wi-Fi 7", label: "Next-gen speed tier" },
            { value: "MeshLink", label: "Whole-home coverage" },
            { value: "2.5 GbE", label: "Fast wired backhaul" },
            { value: "NFC touch", label: "Quick pairing" }
        ],
        sectionTitle: "Router channel highlights",
        sectionIntro: "The router page helps the site feel complete by giving infrastructure products their own family entrance and onward links.",
        highlights: [
            { title: "Flagship speed", text: "StormLink X7 leads with strong wireless speed and premium styling." },
            { title: "Mesh extension", text: "MeshCore Mini expands the story into multi-room coverage." },
            { title: "Travel tier", text: "TravelLink keeps the family usable outside the home." },
            { title: "Whole-home tie-in", text: "The page stays connected to smart-home, support, and store flows." }
        ],
        storyTitle: "Coverage family",
        storyIntro: "This section shows the real structure of the router line instead of reducing the page to a single purchase button.",
        stories: [
            { kicker: "Performance", title: "StormLink X7", text: "A flagship router for demanding households and premium devices." },
            { kicker: "Mesh", title: "MeshCore Mini", text: "A cleaner extension product for wider apartment or house coverage." },
            { kicker: "Portable", title: "TravelLink Go", text: "A compact router for transit, hotels, and temporary work setups." }
        ],
        related: ["wholehome", "support", "store"]
    },
    dragonos: {
        documentTitle: "DragonOS 6",
        pageLabel: "DragonOS 6",
        eyebrow: "DragonGod Phont",
        heroTitle: "One operating layer for phones, wearables, tablets, and whole-home devices.",
        heroSubtitle: "DragonOS 6 is the continuity page that connects the rest of the category site together.",
        heroDescription: "This page fills the same ecosystem role as HarmonyOS on the reference website while keeping all naming and content original.",
        badgeLabel: "Current version",
        badgeValue: "DragonOS 6",
        heroKind: "dragonos",
        heroActions: [
            { label: "Open phones", href: "phones.html", style: "ghost" },
            { label: "Business page", href: "business.html", style: "text" },
            { label: "Support page", href: "support.html", style: "solid" }
        ],
        headerActions: [
            { label: "Business", href: "business.html" },
            { label: "Support", href: "support.html" }
        ],
        metrics: [
            { value: "FlowShare", label: "Cross-device continuity" },
            { value: "Panel Sync", label: "Multi-screen control" },
            { value: "Gesture Hub", label: "Unified interactions" },
            { value: "6 device types", label: "Shared system layer" }
        ],
        sectionTitle: "DragonOS 6 highlights",
        sectionIntro: "The system page behaves as its own destination and ties together phones, tablets, notebooks, and home products.",
        highlights: [
            { title: "Device continuity", text: "Files, calls, and tasks move between hardware families with less friction." },
            { title: "Shared design language", text: "The system unifies motion, controls, and layout across multiple device types." },
            { title: "Whole-home control", text: "Household scenes and display panels stay inside the same operating layer." },
            { title: "Business relevance", text: "The page also links directly to the business view for enterprise deployment narratives." }
        ],
        storyTitle: "System pillars",
        storyIntro: "A platform page should present principles and links across the site, not just a slogan.",
        stories: [
            { kicker: "Continuity", title: "FlowShare", text: "Move content, drafts, and sessions between devices with less interruption." },
            { kicker: "Control", title: "Panel Sync", text: "Share a visual language and control logic across multiple screens and rooms." },
            { kicker: "Enterprise", title: "Secure profile spaces", text: "Separate work and personal states for business deployment and privacy needs." }
        ],
        related: ["computers", "wholehome", "business"]
    },
    support: {
        documentTitle: "DragonGod Support",
        pageLabel: "DragonGod Support",
        eyebrow: "DragonGod Phont",
        heroTitle: "Support pathways for devices, accounts, and after-sales service.",
        heroSubtitle: "A real support landing page connected to login, product details, retail, and the purchase page.",
        heroDescription: "This page gives the Support item a proper destination and stops it from behaving like a dead navigation label.",
        badgeLabel: "Fastest route",
        badgeValue: "Account and device help",
        heroKind: "support",
        heroActions: [
            { label: "Login page", href: LOGIN_URL, style: "ghost" },
            { label: "Product details", href: detailUrl({ section: "support", scene: "support-page" }), style: "text" },
            { label: "Retail page", href: "retail.html", style: "solid" }
        ],
        headerActions: [
            { label: "Login", href: LOGIN_URL },
            { label: "Retail", href: "retail.html" }
        ],
        metrics: [
            { value: "Account", label: "Login and registration help" },
            { value: "Repair", label: "Service pathways" },
            { value: "Retail", label: "Store support routing" },
            { value: "Guides", label: "Device help articles" }
        ],
        sectionTitle: "Support page highlights",
        sectionIntro: "Support should be a real page with its own structure, not just a button that loops back into the homepage.",
        highlights: [
            { title: "Account entry", text: "The existing login and registration page remains the authentication destination." },
            { title: "Device guidance", text: "Users can jump from support into detailed device pages when needed." },
            { title: "Retail routing", text: "Support and retail pages link to each other for in-person service flows." },
            { title: "Site consistency", text: "The same category bar remains present so the whole package still behaves like one site." }
        ],
        storyTitle: "Support pathways",
        storyIntro: "This section explains how users can move from support into the right type of page without confusion.",
        stories: [
            { kicker: "Account", title: "Login and registration", text: "A direct route into the existing authentication page." },
            { kicker: "Product", title: "Product details", text: "A continuation path for specification and feature explanation requests." },
            { kicker: "Offline", title: "Retail handoff", text: "A route for showroom, repair, or in-person assistance visits." }
        ],
        related: ["retail", "business", "phones"]
    },
    retail: {
        documentTitle: "DragonGod Retail",
        pageLabel: "DragonGod Retail",
        eyebrow: "DragonGod Phont",
        heroTitle: "Retail spaces that translate the product story into a physical experience.",
        heroSubtitle: "Showroom layouts, live demos, and guided shopping pathways for larger categories.",
        heroDescription: "The retail page behaves like a real utility destination under the top navigation and helps the whole site feel more complete.",
        badgeLabel: "Retail focus",
        badgeValue: "Showroom and demo routes",
        heroKind: "retail",
        heroActions: [
            { label: "Store page", href: "store.html", style: "ghost" },
            { label: "Support page", href: "support.html", style: "text" },
            { label: "Phones channel", href: "phones.html", style: "solid" }
        ],
        headerActions: [
            { label: "Support", href: "support.html" },
            { label: "DragonMall", href: "store.html" }
        ],
        metrics: [
            { value: "Hands-on", label: "Demo-first visits" },
            { value: "4 zones", label: "Category presentation areas" },
            { value: "Guided", label: "Staff-assisted purchase path" },
            { value: "Repair ready", label: "Support crossover" }
        ],
        sectionTitle: "Retail page highlights",
        sectionIntro: "A separate retail page is a better match for the Huawei-style utility navigation than a homepage anchor or empty button.",
        highlights: [
            { title: "Showroom layout", text: "Phones, wearables, whole-home, and vision products each get a physical presentation zone." },
            { title: "Demo focus", text: "Retail helps larger devices and home products make sense before a purchase page is reached." },
            { title: "Support crossover", text: "Retail and support remain connected for after-sales, pickup, and repair guidance." },
            { title: "Store link", text: "The page still leads onward into the DragonMall utility page instead of duplicating its role." }
        ],
        storyTitle: "Retail structure",
        storyIntro: "The page builds a believable retail layer around the rest of the site instead of leaving the navigation incomplete.",
        stories: [
            { kicker: "Flagship store", title: "City showroom", text: "A large-format environment for foldables, large screens, and ecosystem demos." },
            { kicker: "Mall store", title: "Compact retail point", text: "A smaller store format focused on phones, wearables, and fast support." },
            { kicker: "Service desk", title: "After-sales support zone", text: "A physical handoff point for repair guidance and product help." }
        ],
        related: ["support", "store", "visions"]
    },
    business: {
        documentTitle: "DragonGod Business",
        pageLabel: "DragonGod Business",
        eyebrow: "DragonGod Phont",
        heroTitle: "Business products and deployment stories for teams, schools, and enterprises.",
        heroSubtitle: "A cleaner utility page for commercial use cases across devices and systems.",
        heroDescription: "This page gives the Business item a proper role in the website and makes the top utility row function like a real system.",
        badgeLabel: "Business focus",
        badgeValue: "Cross-device deployment",
        heroKind: "business",
        heroActions: [
            { label: "DragonOS page", href: "dragonos.html", style: "ghost" },
            { label: "Support page", href: "support.html", style: "text" },
            { label: "Store page", href: "store.html", style: "solid" }
        ],
        headerActions: [
            { label: "DragonOS 6", href: "dragonos.html" },
            { label: "Support", href: "support.html" }
        ],
        metrics: [
            { value: "Fleet", label: "Multi-device deployment" },
            { value: "Secure", label: "Managed workspaces" },
            { value: "Meeting", label: "Conference hardware" },
            { value: "Retail", label: "Procurement crossover" }
        ],
        sectionTitle: "Business page highlights",
        sectionIntro: "The business page broadens the site beyond consumer landing pages and makes the overall navigation look more complete.",
        highlights: [
            { title: "Managed devices", text: "Phones, tablets, notebooks, and displays can be described as one deployment family." },
            { title: "Meeting hardware", text: "Audio, vision, and whole-home products all gain a commercial interpretation here." },
            { title: "Secure profile spaces", text: "DragonOS 6 creates a direct system bridge into business use cases." },
            { title: "Procurement path", text: "Retail and store pages remain available for purchasing and fulfillment narratives." }
        ],
        storyTitle: "Business scenarios",
        storyIntro: "A business utility page should explain who the devices are for and how they fit together across departments.",
        stories: [
            { kicker: "Teams", title: "Mobile work kits", text: "Phone, tablet, and notebook sets for flexible day-to-day operations." },
            { kicker: "Meetings", title: "Conference rooms", text: "Displays, audio, and control hubs presented as one meeting stack." },
            { kicker: "Education", title: "Campus deployment", text: "A narrative for student tablets, staff devices, and managed content flow." }
        ],
        related: ["dragonos", "support", "store"]
    },
    store: {
        documentTitle: "DragonMall",
        pageLabel: "DragonMall",
        eyebrow: "DragonGod Phont",
        heroTitle: "A store landing page that gathers categories before the actual product purchase flow.",
        heroSubtitle: "This is the utility-page equivalent of the Huawei mall entrance, not the single product purchase page.",
        heroDescription: "The page gives the Store item a real HTML destination and still links forward into the existing SellPage when the featured product is selected.",
        badgeLabel: "Featured offer",
        badgeValue: "Aether Fold One 12 GB + 256 GB",
        heroKind: "store",
        heroActions: [
            { label: "Open phones channel", href: "phones.html", style: "ghost" },
            { label: "Product details", href: detailUrl({ section: "store", scene: "store-page" }), style: "text" },
            { label: "Buy page", href: sellUrl({ campaign: "store-page", source: "store-page" }), style: "solid" }
        ],
        headerActions: [
            { label: "Support", href: "support.html" },
            { label: "Retail", href: "retail.html" }
        ],
        metrics: [
            { value: "4 zones", label: "Product category groups" },
            { value: "Featured", label: "Current hero product" },
            { value: "Bundle", label: "Accessory pathway" },
            { value: "Route", label: "Buy page handoff" }
        ],
        sectionTitle: "Store page highlights",
        sectionIntro: "This page behaves like a mall or store gateway and then hands users off to the existing product purchase page.",
        highlights: [
            { title: "Featured phone", text: "Aether Fold One remains the highlighted purchase route for the current project package." },
            { title: "Accessory cross-sell", text: "Comet Pen, MagLock cases, and FluxCharge accessories fit naturally here." },
            { title: "Category routing", text: "Phones, wearables, tablets, and audio can all be reached without returning to the homepage." },
            { title: "Sell handoff", text: "The final product buy step still goes to the existing SellPage purchase page." }
        ],
        storyTitle: "Store structure",
        storyIntro: "The store page closes the gap between a global mall button and the actual product purchase page.",
        stories: [
            { kicker: "Featured", title: "Aether Fold One", text: "The flagship device currently promoted across the whole site." },
            { kicker: "Accessories", title: "Creator bundle", text: "Stylus, case, and charging accessories grouped as a coherent set." },
            { kicker: "Services", title: "Support and retail routing", text: "A mall page should still connect to service help and physical locations." }
        ],
        related: ["phones", "support", "retail"]
    }
};

function renderNavLinks(links, currentSlug) {
    return links.map((item) => {
        const activeClass = item.slug === currentSlug ? "active" : "";
        return `<a class="${activeClass}" href="${item.href}">${item.label}</a>`;
    }).join("");
}

function renderButtons(actions) {
    return actions.map((action) => {
        if (action.style === "text") {
            return `<a class="channel-text-link" href="${action.href}">${action.label}</a>`;
        }

        const styleClass = action.style === "solid" ? "solid" : "ghost";
        return `<a class="channel-button ${styleClass}" href="${action.href}">${action.label}</a>`;
    }).join("");
}

function renderHeaderActions(actions) {
    return actions.map((action) => `<a class="channel-header-action" href="${action.href}">${action.label}</a>`).join("");
}

function renderMetrics(metrics) {
    return metrics.map((metric) => `
        <div class="channel-metric">
            <strong>${metric.value}</strong>
            <span>${metric.label}</span>
        </div>
    `).join("");
}

function renderHighlights(items) {
    return items.map((item) => `
        <article class="channel-card">
            <h3>${item.title}</h3>
            <p>${item.text}</p>
        </article>
    `).join("");
}

function renderStories(items) {
    return items.map((item) => `
        <article class="channel-story-card">
            <span class="channel-story-kicker">${item.kicker}</span>
            <h3>${item.title}</h3>
            <p>${item.text}</p>
        </article>
    `).join("");
}

function renderRelated(slugs) {
    return slugs.map((slug) => {
        const page = PAGE_DATA[slug];
        const target = [...CATEGORY_LINKS, ...UTILITY_LINKS].find((item) => item.slug === slug);

        return `
            <article class="channel-related-card">
                <span class="channel-related-kicker">${page.pageLabel}</span>
                <h3>${page.heroTitle}</h3>
                <p>${page.heroDescription}</p>
                <a class="channel-related-link" href="${target.href}">Open page</a>
            </article>
        `;
    }).join("");
}

function renderHeroVisual(kind) {
    const visuals = {
        phones: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Phones hero art">
                <defs>
                    <linearGradient id="p1" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0" stop-color="#4a43a4"/>
                        <stop offset="1" stop-color="#171d6a"/>
                    </linearGradient>
                    <linearGradient id="p2" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0" stop-color="#0f0b39"/>
                        <stop offset="0.55" stop-color="#4436ff"/>
                        <stop offset="1" stop-color="#d6b7ff"/>
                    </linearGradient>
                </defs>
                <rect width="1080" height="640" fill="#ffffff"/>
                <rect x="120" y="170" width="232" height="330" rx="30" fill="url(#p1)" stroke="#292978" stroke-width="8"/>
                <rect x="156" y="214" width="160" height="52" rx="18" fill="#0f1228" stroke="#8c95ec" stroke-width="6"/>
                <circle cx="198" cy="240" r="14" fill="#0b0d23" stroke="#30367c" stroke-width="4"/>
                <circle cx="238" cy="240" r="18" fill="#0b0d23" stroke="#30367c" stroke-width="4"/>
                <circle cx="286" cy="240" r="12" fill="#0b0d23" stroke="#30367c" stroke-width="4"/>
                <rect x="470" y="184" width="500" height="300" rx="28" fill="#111111"/>
                <rect x="486" y="198" width="468" height="272" rx="20" fill="url(#p2)"/>
                <ellipse cx="720" cy="334" rx="154" ry="96" fill="#e8c6ff" fill-opacity="0.78"/>
                <text x="650" y="338" fill="#d9d9ff" font-family="Segoe UI, Arial" font-size="72" font-weight="700">08:08</text>
            </svg>
        `,
        wearables: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Wearables hero art">
                <rect width="1080" height="640" fill="#ffffff"/>
                <rect x="170" y="140" width="140" height="360" rx="70" fill="#111111"/>
                <rect x="190" y="228" width="100" height="186" rx="28" fill="#f5f5f5"/>
                <rect x="205" y="244" width="70" height="154" rx="20" fill="#10163a"/>
                <circle cx="240" cy="322" r="30" fill="#4e42f2"/>
                <circle cx="240" cy="322" r="12" fill="#d7c2ff"/>
                <circle cx="568" cy="322" r="124" fill="#f0f0f0" stroke="#d7d7d7" stroke-width="10"/>
                <circle cx="568" cy="322" r="82" fill="#111111"/>
                <circle cx="568" cy="322" r="26" fill="#c7001e"/>
                <circle cx="840" cy="320" r="74" fill="#ffffff" stroke="#d7d7d7" stroke-width="10"/>
                <circle cx="840" cy="320" r="46" fill="#f4f4f4" stroke="#bdbdbd" stroke-width="6"/>
            </svg>
        `,
        computers: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Computers hero art">
                <defs>
                    <linearGradient id="c1" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0" stop-color="#192655"/>
                        <stop offset="1" stop-color="#69a0ff"/>
                    </linearGradient>
                </defs>
                <rect width="1080" height="640" fill="#ffffff"/>
                <rect x="250" y="120" width="580" height="328" rx="18" fill="#141414"/>
                <rect x="270" y="138" width="540" height="290" rx="10" fill="url(#c1)"/>
                <rect x="214" y="450" width="652" height="34" rx="16" fill="#dadada"/>
                <rect x="354" y="480" width="372" height="28" rx="14" fill="#bcbcbc"/>
                <rect x="356" y="196" width="148" height="92" rx="18" fill="#ffffff" fill-opacity="0.18"/>
                <rect x="528" y="232" width="210" height="28" rx="14" fill="#ffffff" fill-opacity="0.26"/>
                <rect x="528" y="276" width="172" height="18" rx="9" fill="#ffffff" fill-opacity="0.2"/>
            </svg>
        `,
        tablets: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Tablets hero art">
                <defs>
                    <linearGradient id="t1" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0" stop-color="#13214b"/>
                        <stop offset="1" stop-color="#7a9eff"/>
                    </linearGradient>
                </defs>
                <rect width="1080" height="640" fill="#ffffff"/>
                <rect x="196" y="120" width="694" height="392" rx="30" fill="#111111"/>
                <rect x="218" y="142" width="650" height="348" rx="20" fill="url(#t1)"/>
                <circle cx="542" cy="316" r="126" fill="#e1d4ff" fill-opacity="0.72"/>
                <path d="M910 178L960 218L666 514L618 520L624 474L910 178Z" fill="#111111"/>
                <path d="M910 178L960 218" stroke="#e8e8e8" stroke-width="10" stroke-linecap="round"/>
            </svg>
        `,
        visions: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Vision hero art">
                <defs>
                    <linearGradient id="v1" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0" stop-color="#091a45"/>
                        <stop offset="1" stop-color="#7ad0ff"/>
                    </linearGradient>
                </defs>
                <rect width="1080" height="640" fill="#ffffff"/>
                <rect x="130" y="118" width="674" height="376" rx="22" fill="#111111"/>
                <rect x="152" y="138" width="630" height="334" rx="12" fill="url(#v1)"/>
                <rect x="356" y="494" width="222" height="20" rx="10" fill="#bcbcbc"/>
                <rect x="838" y="196" width="126" height="250" rx="22" fill="#f4f4f4" stroke="#d7d7d7" stroke-width="8"/>
                <rect x="862" y="234" width="78" height="140" rx="14" fill="#ececec"/>
            </svg>
        `,
        audio: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Audio hero art">
                <rect width="1080" height="640" fill="#ffffff"/>
                <rect x="168" y="236" width="262" height="168" rx="44" fill="#141414"/>
                <circle cx="260" cy="320" r="56" fill="#2d2d2d"/>
                <circle cx="340" cy="320" r="56" fill="#2d2d2d"/>
                <circle cx="260" cy="320" r="18" fill="#c7001e"/>
                <circle cx="340" cy="320" r="18" fill="#c7001e"/>
                <path d="M680 178C726 178 764 216 764 262V394C764 440 726 478 680 478C634 478 596 440 596 394V262C596 216 634 178 680 178Z" fill="#ffffff" stroke="#d7d7d7" stroke-width="12"/>
                <path d="M882 178C928 178 966 216 966 262V394C966 440 928 478 882 478C836 478 798 440 798 394V262C798 216 836 178 882 178Z" fill="#ffffff" stroke="#d7d7d7" stroke-width="12"/>
                <rect x="638" y="212" width="84" height="202" rx="42" fill="#111111"/>
                <rect x="840" y="212" width="84" height="202" rx="42" fill="#111111"/>
            </svg>
        `,
        wholehome: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Whole home hero art">
                <rect width="1080" height="640" fill="#ffffff"/>
                <path d="M180 426L420 208L660 426V508H180V426Z" fill="#f4f4f4" stroke="#d7d7d7" stroke-width="8"/>
                <rect x="280" y="330" width="100" height="110" rx="12" fill="#ffffff" stroke="#d7d7d7" stroke-width="6"/>
                <rect x="468" y="330" width="100" height="110" rx="12" fill="#ffffff" stroke="#d7d7d7" stroke-width="6"/>
                <circle cx="294" cy="250" r="24" fill="#c7001e"/>
                <circle cx="420" cy="188" r="24" fill="#111111"/>
                <circle cx="546" cy="250" r="24" fill="#c7001e"/>
                <path d="M294 250L420 188L546 250" stroke="#bbbbbb" stroke-width="6"/>
                <rect x="760" y="206" width="168" height="242" rx="26" fill="#111111"/>
                <rect x="778" y="224" width="132" height="206" rx="18" fill="#eff1f7"/>
                <rect x="806" y="260" width="76" height="24" rx="12" fill="#c7001e"/>
                <rect x="806" y="306" width="84" height="16" rx="8" fill="#9a9a9a"/>
                <rect x="806" y="340" width="70" height="16" rx="8" fill="#9a9a9a"/>
            </svg>
        `,
        routers: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Routers hero art">
                <rect width="1080" height="640" fill="#ffffff"/>
                <rect x="286" y="308" width="508" height="120" rx="24" fill="#141414"/>
                <rect x="326" y="276" width="20" height="76" rx="10" fill="#444444"/>
                <rect x="734" y="276" width="20" height="76" rx="10" fill="#444444"/>
                <circle cx="430" cy="368" r="12" fill="#c7001e"/>
                <circle cx="540" cy="368" r="12" fill="#ffffff"/>
                <circle cx="650" cy="368" r="12" fill="#ffffff"/>
                <path d="M540 212C614 212 674 272 674 346" stroke="#d3d3d3" stroke-width="12" fill="none" stroke-linecap="round"/>
                <path d="M540 168C638 168 718 248 718 346" stroke="#ececec" stroke-width="12" fill="none" stroke-linecap="round"/>
                <path d="M540 124C662 124 762 224 762 346" stroke="#f2f2f2" stroke-width="12" fill="none" stroke-linecap="round"/>
            </svg>
        `,
        dragonos: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="DragonOS hero art">
                <defs>
                    <linearGradient id="d1" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0" stop-color="#1b2d64"/>
                        <stop offset="1" stop-color="#6a9eff"/>
                    </linearGradient>
                </defs>
                <rect width="1080" height="640" fill="#ffffff"/>
                <rect x="170" y="140" width="740" height="360" rx="28" fill="url(#d1)"/>
                <rect x="222" y="196" width="170" height="120" rx="22" fill="#ffffff" fill-opacity="0.18"/>
                <rect x="422" y="196" width="210" height="64" rx="22" fill="#ffffff" fill-opacity="0.16"/>
                <rect x="422" y="282" width="142" height="34" rx="17" fill="#ffffff" fill-opacity="0.16"/>
                <rect x="676" y="196" width="170" height="170" rx="22" fill="#ffffff" fill-opacity="0.18"/>
                <rect x="222" y="346" width="410" height="100" rx="22" fill="#ffffff" fill-opacity="0.12"/>
                <text x="498" y="410" fill="#ffffff" font-family="Segoe UI, Arial" font-size="54" font-weight="700">DragonOS 6</text>
            </svg>
        `,
        support: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Support hero art">
                <rect width="1080" height="640" fill="#ffffff"/>
                <rect x="214" y="176" width="250" height="280" rx="24" fill="#f6f6f6" stroke="#d8d8d8" stroke-width="8"/>
                <rect x="266" y="234" width="146" height="22" rx="11" fill="#c7001e"/>
                <rect x="266" y="280" width="146" height="16" rx="8" fill="#a6a6a6"/>
                <rect x="266" y="318" width="118" height="16" rx="8" fill="#a6a6a6"/>
                <circle cx="698" cy="298" r="132" fill="#111111"/>
                <circle cx="698" cy="298" r="90" fill="#f6f6f6"/>
                <path d="M632 330C650 360 678 376 706 376C734 376 760 360 778 330" stroke="#c7001e" stroke-width="16" stroke-linecap="round" fill="none"/>
                <path d="M610 266C626 222 658 200 700 200C742 200 774 222 790 266" stroke="#f6f6f6" stroke-width="18" fill="none" stroke-linecap="round"/>
            </svg>
        `,
        retail: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Retail hero art">
                <rect width="1080" height="640" fill="#ffffff"/>
                <rect x="222" y="204" width="636" height="284" rx="24" fill="#f6f6f6" stroke="#dadada" stroke-width="8"/>
                <rect x="246" y="178" width="588" height="64" rx="18" fill="#c7001e"/>
                <rect x="304" y="278" width="126" height="132" rx="18" fill="#ffffff" stroke="#d3d3d3" stroke-width="6"/>
                <rect x="478" y="278" width="126" height="132" rx="18" fill="#ffffff" stroke="#d3d3d3" stroke-width="6"/>
                <rect x="652" y="278" width="126" height="132" rx="18" fill="#ffffff" stroke="#d3d3d3" stroke-width="6"/>
                <rect x="482" y="436" width="116" height="52" rx="12" fill="#111111"/>
            </svg>
        `,
        business: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Business hero art">
                <rect width="1080" height="640" fill="#ffffff"/>
                <rect x="154" y="184" width="396" height="252" rx="22" fill="#111111"/>
                <rect x="172" y="202" width="360" height="214" rx="14" fill="#1c2d5e"/>
                <rect x="616" y="164" width="220" height="292" rx="22" fill="#f6f6f6" stroke="#d8d8d8" stroke-width="8"/>
                <rect x="868" y="220" width="72" height="236" rx="16" fill="#111111"/>
                <rect x="666" y="220" width="120" height="18" rx="9" fill="#c7001e"/>
                <rect x="666" y="262" width="120" height="14" rx="7" fill="#aaaaaa"/>
                <rect x="666" y="298" width="92" height="14" rx="7" fill="#aaaaaa"/>
                <rect x="214" y="438" width="276" height="34" rx="17" fill="#d1d1d1"/>
            </svg>
        `,
        store: `
            <svg viewBox="0 0 1080 640" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Store hero art">
                <rect width="1080" height="640" fill="#ffffff"/>
                <rect x="194" y="182" width="202" height="270" rx="22" fill="#f6f6f6" stroke="#d8d8d8" stroke-width="8"/>
                <rect x="438" y="152" width="202" height="300" rx="22" fill="#ffffff" stroke="#d8d8d8" stroke-width="8"/>
                <rect x="682" y="182" width="202" height="270" rx="22" fill="#f6f6f6" stroke="#d8d8d8" stroke-width="8"/>
                <rect x="494" y="206" width="90" height="132" rx="18" fill="#111111"/>
                <rect x="514" y="226" width="50" height="92" rx="12" fill="#4f44f6"/>
                <path d="M286 162C286 122 314 100 348 100C382 100 410 122 410 162" stroke="#111111" stroke-width="12" fill="none"/>
                <rect x="264" y="450" width="550" height="38" rx="19" fill="#111111"/>
            </svg>
        `
    };

    return visuals[kind] || visuals.phones;
}

function renderPage(currentSlug) {
    const page = PAGE_DATA[currentSlug];
    if (!page) {
        document.body.innerHTML = "<main style='padding:40px;font-family:Segoe UI,Arial,sans-serif'>Page data not found.</main>";
        return;
    }

    document.title = page.documentTitle;

    document.body.className = "channel-page";
    document.body.innerHTML = `
        <header class="channel-global-bar">
            <div class="channel-global-inner">
                <a class="channel-brand" href="../index.html" aria-label="DragonGod Phont homepage">
                    <span class="channel-brand-mark" aria-hidden="true"></span>
                    <span>DragonGod Phont</span>
                </a>

                <nav class="channel-site-nav" aria-label="Site categories">
                    ${renderNavLinks(CATEGORY_LINKS, currentSlug)}
                </nav>

                <nav class="channel-utility-nav" aria-label="Utility pages">
                    ${renderNavLinks(UTILITY_LINKS, currentSlug)}
                </nav>
            </div>
        </header>

        <div class="channel-subbar">
            <div class="channel-subbar-inner">
                <div class="channel-page-title">${page.pageLabel}</div>

                <nav class="channel-section-nav" aria-label="Section shortcuts">
                    <a href="#overview">Overview</a>
                    <a href="#highlights">Channel Highlights</a>
                    <a href="#stories">Use Cases</a>
                    <a href="#links">Related Pages</a>
                </nav>

                <div class="channel-header-actions">
                    ${renderHeaderActions(page.headerActions)}
                </div>
            </div>
        </div>

        <main class="channel-main">
            <section class="channel-section channel-hero" id="overview">
                <div class="channel-hero-grid">
                    <div class="channel-hero-copy">
                        <p class="channel-eyebrow">${page.eyebrow}</p>
                        <h1 class="channel-hero-title">${page.heroTitle}</h1>
                        <p class="channel-hero-subtitle">${page.heroSubtitle}</p>
                        <p class="channel-hero-description">${page.heroDescription}</p>
                        <div class="channel-hero-badge">
                            <span>${page.badgeLabel}</span>
                            <strong>${page.badgeValue}</strong>
                        </div>
                        <div class="channel-hero-actions">
                            ${renderButtons(page.heroActions)}
                        </div>
                    </div>

                    <div class="channel-hero-visual">
                        <div class="channel-hero-art">
                            ${renderHeroVisual(page.heroKind)}
                        </div>
                    </div>
                </div>
            </section>

            <section class="channel-section channel-metrics-wrap">
                <div class="channel-metrics">
                    ${renderMetrics(page.metrics)}
                </div>
            </section>

            <section class="channel-section" id="highlights">
                <div class="channel-panel">
                    <div class="channel-section-header">
                        <p class="channel-eyebrow">Channel Highlights</p>
                        <h2>${page.sectionTitle}</h2>
                        <p class="channel-section-intro">${page.sectionIntro}</p>
                    </div>

                    <div class="channel-card-grid">
                        ${renderHighlights(page.highlights)}
                    </div>
                </div>
            </section>

            <section class="channel-section" id="stories">
                <div class="channel-panel">
                    <div class="channel-section-header">
                        <p class="channel-eyebrow">Use Cases</p>
                        <h2>${page.storyTitle}</h2>
                        <p class="channel-section-intro">${page.storyIntro}</p>
                    </div>

                    <div class="channel-story-grid">
                        ${renderStories(page.stories)}
                    </div>
                </div>
            </section>

            <section class="channel-section" id="links">
                <div class="channel-panel">
                    <div class="channel-section-header">
                        <p class="channel-eyebrow">Related Pages</p>
                        <h2>Continue into other standalone pages</h2>
                        <p class="channel-section-intro">These are real HTML pages inside the package, linked to each other like a multi-page brand website rather than homepage anchors.</p>
                    </div>

                    <div class="channel-related-grid">
                        ${renderRelated(page.related)}
                    </div>
                </div>
            </section>
        </main>

        <footer class="channel-footer">
            <div class="channel-footer-copy">
                <strong>DragonGod Phont</strong>
                <p>Multi-page category site generated for the top navigation structure, while the existing login, detail, and purchase pages remain unchanged.</p>
            </div>

            <div class="channel-footer-actions">
                <a href="../index.html">Back to homepage</a>
                <a href="${detailUrl({ section: "footer", scene: `${currentSlug}-page` })}">Product details</a>
                <a href="${sellUrl({ campaign: `${currentSlug}-footer`, source: `${currentSlug}-page` })}">Buy page</a>
            </div>
        </footer>

        <aside class="channel-notice" id="channel-notice">
            <p>This multi-page channel layer exists to make the top navigation fully clickable and interconnected, while keeping the original core pages unchanged.</p>
            <button class="channel-notice-close" type="button" aria-label="Dismiss channel notice">×</button>
        </aside>
    `;

    const noticeClose = document.querySelector(".channel-notice-close");
    if (noticeClose) {
        noticeClose.addEventListener("click", () => {
            const notice = document.getElementById("channel-notice");
            if (notice) {
                notice.hidden = true;
            }
        });
    }
}

renderPage(document.body.dataset.page);