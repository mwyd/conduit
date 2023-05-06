import useTheme, { toggleTheme } from "@/hooks/use-theme";

export default function ThemeSwitch() {
  const { icon: themeIcon } = useTheme();

  return (
    <button
      className="select-none cursor-pointer mx-2"
      title="theme-switch"
      type="button"
      onClick={toggleTheme}
    >
      {themeIcon}
    </button>
  );
}