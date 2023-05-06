import { ReactNode } from "react";
import { Paginator } from "@/types/pagination";
import { SummaryItemHistory } from "@/types/items";
import { DefaultLayout } from "@/layouts/default-layout";
import SummaryItemHistoryTable from "@/components/summary-item-history-table";

interface Props {
  hashName: string;
  paginator: Paginator<SummaryItemHistory>;
}

function Item({ hashName, paginator }: Props) {
  return (
    <section className="py-4">
      <header>
        <h1 className="text-2xl font-semibold">
          {hashName}
        </h1>
        <p className="mt-4 text-gray-500 dark:text-gray-400 text-sm">
          Statistics <b>also include</b> transactions that have been marked as <i>cancelled</i>.
        </p>
      </header>
      <div className="mt-4">
        <SummaryItemHistoryTable paginator={paginator} />
      </div>
    </section>
  );
}

Item.layout = (page: ReactNode) => (
  <DefaultLayout>
    {page}
  </DefaultLayout>
);

export default Item;