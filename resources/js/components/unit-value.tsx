import { formatNumber } from "../utils";
import React from "react";

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