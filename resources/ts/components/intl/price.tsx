import { FormattedNumber } from "react-intl";

interface Props {
  value: number;
}

export default function Price({ value }: Props) {
  return (
    <FormattedNumber
      value={value}
      style="currency"
      currency="USD"
    />
  );
}