import { AnchorHTMLAttributes, ReactNode } from "react";

interface Props extends AnchorHTMLAttributes<HTMLAnchorElement> {
  href: string;
  title: string;
  children: ReactNode;
}

export default function Anchor({ href, title, children, rel = 'noreferrer', ...reset }: Props) {
  return (
    <a
      title={title}
      href={href}
      rel={rel}
      {...reset}
    >
      {children}
    </a>
  );
}