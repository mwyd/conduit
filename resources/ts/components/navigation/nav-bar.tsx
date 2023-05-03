import ThemeSwitch from "../theme-switch";
import Logo from "./logo";
import DocsButton from "./docs-button";
import CurrencySelect from "../currency-select";

export default function NavBar() {
  return (
    <nav className="border-b h-14 dark:border-b-neutral-700">
      <div className="max-w-7xl h-full mx-auto py-2 px-4 flex items-center justify-between">
        <Logo />
        <div className="flex">
          <CurrencySelect />
          <ThemeSwitch />
          <DocsButton />
        </div>
      </div>
    </nav>
  );
}