import { FormattedNumber } from "react-intl";

interface Props {
  value: number;
  precision?: number;
}

export default function Percentage({ value, precision = 2 }: Props) {
  return (
    <FormattedNumber
      value={value / 100}
      style="percent"
      minimumFractionDigits={precision}
      maximumFractionDigits={precision}
    />
  );
}