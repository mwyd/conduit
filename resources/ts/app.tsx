import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";
import { StrictMode } from "react";
import { IntlProvider } from "react-intl";
import { getLocale } from "@/utils";

import '../css/app.css';

createInertiaApp({
  title: title => `Conduit - ${title}`,
  resolve: name => {
    const pages = import.meta.glob('./pages/**/*.tsx', { eager: true });
    return pages[`./pages/${name}.tsx`];
  },
  setup({ el, App, props }) {
    createRoot(el).render(
      <StrictMode>
        <IntlProvider locale={getLocale('en')}>
          <App {...props} />
        </IntlProvider>
      </StrictMode>
    );
  },
});