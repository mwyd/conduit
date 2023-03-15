import { DefaultLayout } from "../layouts/default-layout";
import React, { ReactNode } from "react";
import { MarketStatistics } from "../types/statistics";
import { SummaryItem } from "../types/items";
import StatisticsBar from "../components/statistics-bar";
import SummaryItemsTable from "../components/summary-items-table";
import { Paginator } from "../types/pagination";

interface Props {
  statistics: MarketStatistics;
  paginator: Paginator<SummaryItem>;
}

function Index({ statistics, paginator }: Props) {
  return (
    <section className="py-4">
      <header>
        <h1 className="text-2xl font-semibold">
          Shadowpay market status
        </h1>
        <p className="mt-4 text-gray-500 dark:text-gray-400 text-sm">
          Statistics <b>aslo includes</b> transactions that have been marked as <i>cancelled</i>.
        </p>
      </header>
      <div className="mt-4">
        <StatisticsBar statistics={statistics} />
      </div>
      <div className="mt-4">
        <SummaryItemsTable paginator={paginator} />
      </div>
    </section>
  );
}

Index.layout = (page: ReactNode) => (
  <DefaultLayout>
    {page}
  </DefaultLayout>
);

export default Index;