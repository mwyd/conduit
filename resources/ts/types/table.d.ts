export default interface Column<T extends object> {
  name: string;
  accessor: keyof T;
  className?: string;
}