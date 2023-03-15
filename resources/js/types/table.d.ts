export default interface Column<T extends Object> {
  name: string;
  accessor: keyof T;
}