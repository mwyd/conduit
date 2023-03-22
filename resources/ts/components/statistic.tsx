import classNames from "classnames";
import { ReactNode } from "react";
import Percentage from "./intl/percentage";
import { VscArrowDown, VscArrowUp } from "react-icons/vsc";

const containerClass = (isNegative: boolean) => classNames([
  'shadow',
  'rounded',
  'p-4',
  'border-l-4',
  'dark:bg-neutral-800',
  isNegative ? 'border-red-500' : 'border-green-500'
]);

const differenceClass = (isNegative: boolean) => classNames([
  'absolute',
  'top-0',
  'right-0',
  'text-sm',
  'flex',
  'items-center',
  'gap-1',
  isNegative ? 'text-red-500' : 'text-green-500'
]);

interface Props {
  difference: number;
  title: string;
  children: ReactNode;
}

export default function Statistic({ difference, title, children }: Props) {
  const isNegative = difference < 0;

  const Icon = isNegative ? VscArrowDown : VscArrowUp;

  return (
    <div className={containerClass(isNegative)}>
      <div className="relative">
        <h2 className="text-xl">
          {children}
        </h2>
        <p className="text-sm text-gray-500 dark:text-gray-400">
          {title}
        </p>
        <span className={differenceClass(isNegative)}>
          <Percentage value={difference} />
          <Icon size={16} />
        </span>
      </div>
    </div>
  );
}