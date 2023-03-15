import { MarketStatistic } from "../types/statistics";
import classNames from "classnames";
import { formatNumber } from "../utils";
import { ReactNode } from "react";

const containerClass = (isNegative: boolean) => classNames([
  'shadow',
  'rounded',
  'p-4',
  'border-l-4',
  'dark:bg-neutral-800',
  isNegative ? 'border-red-500' : 'border-green-500'
]);

const headingClass = (isNegative: boolean) => classNames([
  'text-xl',
  'relative',
  `after:content-[attr(data-difference)]`,
  'after:text-sm',
  'after:top-0',
  'after:right-0',
  'after:absolute',
  isNegative ? 'after:text-red-500' : 'after:text-green-500'
]);

interface Props {
  difference: number;
  title: string;
  children: ReactNode;
}

export default function Statistic({ difference, title, children }: Props) {
  const isNegative = difference < 0;

  const differenceText = formatNumber(difference) + (isNegative ? ' 🡦' : ' 🡥');

  return (
    <div className={containerClass(isNegative)}>
      <h2
        data-difference={differenceText}
        className={headingClass(isNegative)}
      >
        {children}
      </h2>
      <p className="text-sm text-gray-500 dark:text-gray-400">
        {title}
      </p>
    </div>
  );
}