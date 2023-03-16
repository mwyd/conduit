import { formatNumber } from "../utils";

interface Props {
  value: number;
  unit: string;
  precision?: number;
}

export default function UnitValue({ value, unit, precision = 2 }: Props) {
  return (
    <>
      <span>{unit} </span>
      {formatNumber(value, precision)}
    </>
  );
}