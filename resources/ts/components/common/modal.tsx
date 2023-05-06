import { createPortal } from "react-dom";
import { ReactNode, useEffect } from "react";
import { VscClose } from "react-icons/all";
import { getYScrollBarWidth } from "@/utils";
import Button from "@/components/common/button";

interface Props {
  title: string;
  isOpen: boolean;
  handleClose: () => void;
  children: ReactNode;
}

export default function Modal({ title, isOpen, handleClose, children }: Props) {
  useEffect(() => {
    const body = document.body;

    if (isOpen) {
      body.style.paddingRight = getYScrollBarWidth() + 'px';
      body.style.overflow = 'hidden';
    } else {
      body.style.paddingRight = 'unset';
      body.style.overflow = 'unset';
    }
  }, [isOpen]);

  if (!isOpen) {
    return null;
  }

  const node = (
    <div className="fixed w-full h-full top-0 left-0 z-50 p-4 overflow-auto bg-semi-transparent">
      <div className="mx-auto max-w-lg bg-white shadow rounded-md p-4 dark:bg-neutral-900 dark:text-gray-200">
        <div className="flex items-center justify-between gap-2 font-semibold">
          <h1>{title}</h1>
          <Button
            onClick={handleClose}
            variant="transparent"
            title="Close"
          >
            <VscClose />
          </Button>
        </div>
        <div className="mt-4">
          {children}
        </div>
      </div>
    </div>
  );

  return createPortal(node, document.body);
}