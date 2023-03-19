import { Link } from "@inertiajs/react";
import classNames from "classnames";
import { ReactNode } from "react";

const linkClass = (isActive: boolean, hasUrl: boolean) => classNames([
  'py-2',
  'mx-0.5',
  'w-8',
  'text-center',
  'inline-block',
  'rounded-md',
  hasUrl ? 'cursor-pointer hover:bg-black hover:text-white dark:hover:bg-neutral-600' : 'cursor-auto',
  isActive ? 'border border-neutral-600' : ''
]);

interface Props {
  active: boolean;
  url: string | null;
  children: ReactNode;
}

export default function PaginationLink({ active, url, children }: Props) {
  if (!url) {
    return (
      <button
        className={linkClass(active, false)}
        type="button"
      >
        {children}
      </button>
    )
  }

  return (
    <Link
      className={linkClass(active, true)}
      href={url}
    >
      {children}
    </Link>
  );
}