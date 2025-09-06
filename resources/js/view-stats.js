// Poll live view stats and update counters in the DOM
// Looks for elements with ids: stat-now-<id>, stat-today-<id>, stat-total-<id>

function collectCameraIds() {
    const ids = new Set();
    document.querySelectorAll('[id^="stat-now-"]').forEach(el => {
        const id = el.id.replace('stat-now-', '');
        if (id) ids.add(id);
    });
    // also allow presence only of today/total
    document.querySelectorAll('[id^="stat-today-"]').forEach(el => {
        const id = el.id.replace('stat-today-', '');
        if (id) ids.add(id);
    });
    document.querySelectorAll('[id^="stat-total-"]').forEach(el => {
        const id = el.id.replace('stat-total-', '');
        if (id) ids.add(id);
    });
    return Array.from(ids);
}

async function fetchStats(ids) {
    if (!ids.length) return {};
    const params = new URLSearchParams({ ids: ids.join(',') });
    const res = await fetch(`/api/streaming/stats?${params.toString()}`, { headers: { 'Accept': 'application/json' } });
    if (!res.ok) throw new Error('Failed to fetch stats ' + res.status);
    return await res.json();
}

function renderStats(stats) {
    Object.entries(stats || {}).forEach(([id, obj]) => {
        const nowEl = document.getElementById(`stat-now-${id}`);
        if (nowEl) nowEl.textContent = (obj?.now ?? 0);
        const todayEl = document.getElementById(`stat-today-${id}`);
        if (todayEl) todayEl.textContent = (obj?.today ?? 0);
        const totalEl = document.getElementById(`stat-total-${id}`);
        if (totalEl) totalEl.textContent = (obj?.total ?? 0);
    });
}

async function runStatsPoll() {
    try {
        const ids = collectCameraIds();
        if (!ids.length) return;
        const stats = await fetchStats(ids);
        renderStats(stats);
    } catch (e) {
        // silent retry
        console.debug('stats poll error', e);
    }
}

// Start polling when DOM is ready (handles late-loaded module scripts too)
if (typeof window !== 'undefined') {
    const start = () => {
        runStatsPoll();
        // Poll every 20s; tune via VIEWERS_ACTIVE_WINDOW (server side)
        if (!window.__viewStatsInterval) {
            window.__viewStatsInterval = setInterval(runStatsPoll, 20000);
        }
    };
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start, { once: true });
    } else {
        start();
    }
}
