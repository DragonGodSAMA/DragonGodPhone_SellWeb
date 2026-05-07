const routes = {
    login: {
        path: "../Login and Registration_Xwk/Login.html",
        defaultParams: {
            mode: "login",
            source: "homepage",
            redirect: "sell"
        }
    },
    register: {
        path: "../Login and Registration_Xwk/Registration.html",
        defaultParams: {
            mode: "register",
            source: "homepage",
            redirect: "sell"
        }
    },
    detail: {
        path: "../Detail_Introduction_Page-ZhuoChen/DetailIntroductinoPage-ZhuoChen.html",
        defaultParams: {
            product: "aether-fold-one",
            section: "story",
            scene: "homepage"
        }
    },
    sell: {
        path: "../SellPage/SellPage.html",
        defaultParams: {
            sku: "aether-fold-one-512",
            campaign: "homepage",
            source: "homepage"
        }
    }
};

const showcaseContent = {
    canvas: {
        tag: "Creative AI",
        title: "Mythic Canvas AI turns quick sketches into presentable concepts.",
        text: "The homepage showcases AI creation as a visual story layer while keeping the actual conversion path separate from the buy flow.",
        points: [
            "Sketch-to-scene prompt support",
            "Moodboard-style generation framing",
            "Stylus-first concept drafting"
        ],
        image: "assets/feature-stylus.svg",
        alt: "Stylized stylus illustration"
    },
    camera: {
        tag: "StarSight Imaging",
        title: "A camera story focused on composition guidance and night clarity.",
        text: "Instead of copying the official camera wording, this homepage introduces a new photo system identity with original labels and use cases.",
        points: [
            "Pose suggestions for portraits",
            "Color-balanced evening scenes",
            "Macro depth for texture shots"
        ],
        image: "assets/feature-camera.svg",
        alt: "Stylized camera illustration"
    },
    travel: {
        tag: "Travel AI",
        title: "Mythic AI can frame the device as a quiet travel companion.",
        text: "The landing page introduces proactive planning, route awareness, and itinerary prompts while reserving account-dependent actions for the login flow.",
        points: [
            "Trip reminders and timing hints",
            "Context-driven topic suggestions",
            "Source-aware links into login or buy"
        ],
        image: "assets/feature-core.svg",
        alt: "Stylized AI core illustration"
    },
    workflow: {
        tag: "Work Hub",
        title: "Large-canvas workflow scenes keep the homepage useful beyond pure marketing.",
        text: "This section suggests document preview, deck editing, and side-by-side planning to mirror the reference structure without copying its visuals or text.",
        points: [
            "Desk mode viewing",
            "Wide-layout document preview",
            "Accessory-ready productivity story"
        ],
        image: "assets/hero-device.svg",
        alt: "Stylized foldable device illustration"
    }
};

function buildUrl(routeKey, extraParams = {}) {
    const route = routes[routeKey];

    if (!route) {
        return null;
    }

    const params = new URLSearchParams({
        ...route.defaultParams,
        ...extraParams
    });

    return `${route.path}?${params.toString()}`;
}

function navigateFromButton(event) {
    const button = event.currentTarget;
    const routeKey = button.dataset.route;
    const queryPayload = button.dataset.query ? JSON.parse(button.dataset.query) : {};
    const target = buildUrl(routeKey, queryPayload);

    if (target) {
        window.location.href = target;
    }
}

function updateShowcase(key) {
    const content = showcaseContent[key];

    if (!content) {
        return;
    }

    document.getElementById("showcase-tag").textContent = content.tag;
    document.getElementById("showcase-title").textContent = content.title;
    document.getElementById("showcase-text").textContent = content.text;

    const list = document.getElementById("showcase-points");
    list.innerHTML = content.points.map((point) => `<li>${point}</li>`).join("");

    const image = document.getElementById("showcase-image");
    image.src = content.image;
    image.alt = content.alt;
}

function animateCounter(element) {
    const targetValue = Number(element.dataset.counter);

    if (!targetValue) {
        return;
    }

    const duration = 1200;
    const start = performance.now();

    function frame(timestamp) {
        const elapsed = timestamp - start;
        const progress = Math.min(elapsed / duration, 1);
        const value = targetValue * progress;
        const displayValue = Number.isInteger(targetValue) ? Math.round(value) : value.toFixed(1);

        element.textContent = displayValue;

        if (progress < 1) {
            requestAnimationFrame(frame);
        }
    }

    requestAnimationFrame(frame);
}

function setupCounters() {
    const counters = document.querySelectorAll("[data-counter]");
    const observer = new IntersectionObserver((entries, counterObserver) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.45 });

    counters.forEach((counter) => observer.observe(counter));
}

function setupNavHighlight() {
    const links = [...document.querySelectorAll(".primary-nav a")];
    const sections = links
        .map((link) => document.querySelector(link.getAttribute("href")))
        .filter(Boolean);

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            links.forEach((link) => {
                const active = link.getAttribute("href") === `#${entry.target.id}`;
                link.classList.toggle("active", active);
            });
        });
    }, {
        threshold: 0.45,
        rootMargin: "-20% 0px -35% 0px"
    });

    sections.forEach((section) => observer.observe(section));
}

function setupMenu() {
    const header = document.querySelector(".site-header");
    const toggle = document.querySelector(".menu-toggle");

    toggle.addEventListener("click", () => {
        const expanded = toggle.getAttribute("aria-expanded") === "true";
        toggle.setAttribute("aria-expanded", String(!expanded));
        header.classList.toggle("menu-open", !expanded);
    });
}

function setupNotice() {
    const notice = document.getElementById("notice-bar");
    const closeButton = document.querySelector(".notice-close");

    closeButton.addEventListener("click", () => {
        notice.hidden = true;
    });
}

document.querySelectorAll("[data-route]").forEach((button) => {
    button.addEventListener("click", navigateFromButton);
});

document.querySelectorAll(".switch-chip").forEach((button) => {
    button.addEventListener("click", () => {
        document.querySelectorAll(".switch-chip").forEach((chip) => chip.classList.remove("active"));
        button.classList.add("active");
        updateShowcase(button.dataset.showcase);
    });
});

setupCounters();
setupNavHighlight();
setupMenu();
setupNotice();
updateShowcase("canvas");