import { InputHTMLAttributes } from "react";
import classNames from "classnames";

export default function Input({ className, ...rest }: InputHTMLAttributes<HTMLInputElement>) {
  return (
    <input
      className={classNames('rounded-md bg-gray-50 dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 p-1', className)}
      {...rest}
    />
  );
}