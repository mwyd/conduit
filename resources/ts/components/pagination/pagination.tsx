import { PaginatorLink } from "../../types/pagination";
import PaginationLink from "./pagination-link";
import { scalePaginatorLinks } from "../../utils";

interface Props {
  links: PaginatorLink[];
}

export default function Pagination({ links }: Props) {
  const [sm, md] = scalePaginatorLinks(links);

  const renderer = (link: PaginatorLink, index: number) => {
    return (
      <PaginationLink
        key={index}
        active={link.active}
        url={link.url}
        preserveState={true}
      >
        {link.label}
      </PaginationLink>
    );
  }

  return (
    <div className="text-center text-xs">
      <span className="hidden md:block">
        {md.map(renderer)}
      </span>
      <span className="block md:hidden">
        {sm.map(renderer)}
      </span>
    </div>
  );
}