import { ReactNode } from "react";
import NavBar from "../components/nav-bar";

interface Props {
  children: ReactNode;
}

export function DefaultLayout({ children }: Props) {
  return (
    <div className="dark:bg-neutral-900 dark:text-gray-200">
      <NavBar />
      <div className="px-4 max-w-7xl mx-auto">
        {children}
      </div>
    </div>
  );
}