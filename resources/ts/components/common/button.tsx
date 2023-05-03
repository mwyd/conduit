import { ButtonHTMLAttributes } from "react";
import classNames from "classnames";

interface Props extends ButtonHTMLAttributes<HTMLButtonElement> {
  variant?: 'primary' | 'secondary' | 'outlined' | 'transparent';
}

export default function Button({ children, className, variant = 'primary', type = 'button', ...rest }: Props) {
  return (
    <button
      className={classNames(`button-${variant}`, className)}
      type={type}
      {...rest}
    >
      {children}
    </button>
  );
}