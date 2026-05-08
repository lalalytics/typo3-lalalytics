interface LalaEvent {
    type: string;
    sel: string;
    name: string;
    tags: string[] | null;
    attr: string;
}

interface LalaTagsPayload {
    tags: string[];
}

type LalaEventMap = Record<string, LalaEvent[]>;

declare global {
    interface Window {
        lala?: (name: string, payload: LalaTagsPayload) => void;
        lalaGlobalTags?: string[];
    }
}

(function (): void {
    const dataElement = document.getElementById('lala-events-data');
    if (!dataElement?.textContent) return;

    const events: LalaEventMap = JSON.parse(dataElement.textContent);

    const _lala = (name: string, payload: LalaTagsPayload): void => {
        if (typeof window.lala === 'function') {
            window.lala(name, payload);
        } else {
            console.log(name, payload);
        }
    };

    const parseTags = (tags: string[] | null): LalaTagsPayload => {
        const baseTags = tags ?? [];
        return Array.isArray(window.lalaGlobalTags)
            ? { tags: window.lalaGlobalTags.concat(baseTags) }
            : { tags: baseTags };
    };

    const defaultHandler = (ev: Event): void => {
        const target = ev.target as Element | null;
        if (!target) return;

        events[ev.type]?.forEach((e: LalaEvent) => {
            const el = target.closest(e.sel);
            if (el !== null) {
                let tags = e.tags ?? [];
                if (e.attr) {
                    const attrValue = el.getAttribute(e.attr);
                    if (attrValue) {
                        tags = tags.concat(attrValue);
                    }
                }
                _lala(e.name, parseTags(tags));
            }
        });
    };

    const hashchangeHandler = (ev: HashChangeEvent): void => {
        events[ev.type]
            ?.filter((e: LalaEvent) => e.sel === location.hash)
            .forEach((e: LalaEvent) => _lala(e.name, parseTags(e.tags)));
    };

    Object.keys(events).forEach((eventType: string) => {
        const handler = eventType === 'hashchange' ? hashchangeHandler : defaultHandler;
        window.addEventListener(eventType, handler as EventListener, { passive: true });
    });
})();
