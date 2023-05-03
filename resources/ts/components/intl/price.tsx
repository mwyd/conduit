import { FormattedNumber } from "react-intl";
import useCurrency from "../../hooks/use-currency";

interface Props {
  value: number;
}

export default function Price({ value }: Props) {
  const { iso, ratio } = useCurrency();

  return (
    <FormattedNumber
      value={value * ratio}
      style="currency"
      currency={iso}
    />
  );
}