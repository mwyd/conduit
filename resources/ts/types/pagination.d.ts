export interface PaginatorLink {
  active: boolean;
  url: string | null;
  label: string;
}

export interface Paginator<T> {
  links: PaginatorLink[];
  data: T[];
}