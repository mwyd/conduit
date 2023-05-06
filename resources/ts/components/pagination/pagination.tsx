import { PaginatorLink } from "@/types/pagination";
import PaginationLink from "@/components/pagination/pagination-link";

function scalePaginatorLinks(links: PaginatorLink[]): [PaginatorLink[], PaginatorLink[]] {
  if (links.length < 1) {
    return [links, links];
  }

  let sm = [...links];

  if (sm.length > 5) {
    sm = sm.filter(link => link.label != '...');

    let activeIndex = sm.findIndex(link => link.active);

    if (activeIndex == -1) {
      activeIndex = sm.length - 2;
    }

    const first = sm[0];
    const last = sm[sm.length - 1];

    if (activeIndex - 1 == 0) {
      sm = sm.slice(activeIndex, activeIndex + 3);
    } else if (activeIndex + 1 == sm.length - 1) {
      sm = sm.slice(activeIndex - 2, activeIndex + 1);
    } else {
      sm = sm.slice(activeIndex - 1, activeIndex + 2);
    }

    sm = [first, ...sm, last];
  }

  return [sm, links];
}

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